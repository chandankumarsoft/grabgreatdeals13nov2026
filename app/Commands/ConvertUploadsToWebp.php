<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\BaseConnection;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use Throwable;

final class ConvertUploadsToWebp extends BaseCommand
{
    protected $group       = 'Media';
    protected $name        = 'media:convert-uploads-to-webp';
    protected $description = 'Create WebP copies of uploaded JPEG and PNG images and update matching database references.';
    protected $usage       = 'media:convert-uploads-to-webp [--execute] [--quality 82] [--worker 0 --workers 4] [--trust-existing] [--delete-originals]';
    protected $options     = [
        '--execute'  => 'Convert files and update matching database references. Defaults to dry-run.',
        '--quality'  => 'WebP quality from 0 to 100. Defaults to 82.',
        '--worker'   => 'Optional zero-based worker index. Worker mode converts files only; run a normal --execute afterward to update references.',
        '--workers'  => 'Total worker count when using --worker.',
        '--trust-existing' => 'Skip WebP validation for existing targets after all conversion workers have verified them.',
        '--delete-originals' => 'Delete source files only after successful conversion, reference updates, and WebP decoding.',
    ];

    private const SOURCE_EXTENSIONS = ['jpg', 'jpeg', 'png'];

    public function run(array $params)
    {
        if (! function_exists('imagewebp') || ! function_exists('imagecreatefromstring')) {
            throw new RuntimeException('PHP GD with WebP support is required.');
        }

        $execute = CLI::getOption('execute') !== null;
        $trustExisting = CLI::getOption('trust-existing') !== null;
        $deleteOriginals = CLI::getOption('delete-originals') !== null;
        $qualityOption = CLI::getOption('quality');
        $quality = $qualityOption === null ? 82 : (int) $qualityOption;
        if ($quality < 0 || $quality > 100) {
            throw new RuntimeException('WebP quality must be between 0 and 100.');
        }

        $workerCount = (int) (CLI::getOption('workers') ?? 1);
        $workerOption = CLI::getOption('worker');
        $workerIndex = null;
        if ($workerCount < 1 || $workerCount > 16) {
            throw new RuntimeException('Worker count must be between 1 and 16.');
        }
        if ($workerOption !== null) {
            if (! ctype_digit((string) $workerOption) || (int) $workerOption >= $workerCount) {
                throw new RuntimeException('Worker index must be between 0 and worker count minus one.');
            }
            $workerIndex = (int) $workerOption;
        } elseif ($workerCount !== 1) {
            throw new RuntimeException('Specify a zero-based --worker index when using multiple workers.');
        }
        if (! $execute && $workerIndex !== null) {
            throw new RuntimeException('Worker mode requires --execute.');
        }
        if ($trustExisting && (! $execute || $workerIndex !== null)) {
            throw new RuntimeException('--trust-existing requires a non-worker --execute run.');
        }
        if ($deleteOriginals && (! $execute || $workerIndex !== null || $trustExisting)) {
            throw new RuntimeException('--delete-originals requires a validated, non-worker --execute run.');
        }

        $uploadDirectory = rtrim(FCPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'uploads';
        if (! is_dir($uploadDirectory)) {
            throw new RuntimeException('The public uploads directory was not found.');
        }

        $files = $this->imageFiles($uploadDirectory);
        $collisionTargets = $this->collisionSafeTargets($files);
        $collisionTargetPaths = [];
        foreach ($collisionTargets as $source => $target) {
            $sourceRelativePath = strtolower(str_replace(
                DIRECTORY_SEPARATOR,
                '/',
                substr($source, strlen($uploadDirectory) + 1),
            ));
            $targetRelativePath = strtolower(str_replace(
                DIRECTORY_SEPARATOR,
                '/',
                substr($target, strlen($uploadDirectory) + 1),
            ));
            $collisionTargetPaths[$sourceRelativePath] = $targetRelativePath;
        }
        $totalBytes = array_sum(array_map(static fn (string $file): int => (int) filesize($file), $files));
        CLI::write(sprintf(
            '%s: %d JPEG/PNG files, %.2f GB source data. Animated GIFs will be preserved%s.',
            $workerIndex === null ? ($execute ? 'Executing conversion' : 'Dry run') : "Worker {$workerIndex} converting",
            count($files),
            $totalBytes / 1024 / 1024 / 1024,
            $deleteOriginals ? '; verified originals will be deleted' : '; original files will be preserved',
        ));

        if (! $execute) {
            $this->reportDatabaseReferences(db_connect(), $uploadDirectory, $files);
            CLI::write('No files or database rows were changed. Re-run with --execute after creating a database backup.');

            return;
        }

        $database = db_connect();
        $convertedPaths = [];
        $convertedBasenames = [];
        $workerSuffix = $workerIndex === null ? 'all' : 'worker-' . $workerIndex;
        $failureLog = WRITEPATH . 'logs' . DIRECTORY_SEPARATOR . 'webp-conversion-failures-' . date('Ymd-His') . '-' . $workerSuffix . '.log';
        $failures = [];
        $converted = 0;
        $reused = 0;
        $originalBytes = 0;
        $webpBytes = 0;
        $processed = 0;
        $assignedCount = $workerIndex === null
            ? count($files)
            : intdiv(count($files) + $workerCount - 1 - $workerIndex, $workerCount);

        foreach ($files as $index => $source) {
            if ($workerIndex !== null && $index % $workerCount !== $workerIndex) {
                continue;
            }
            $processed++;
            $relativePath = strtolower(str_replace(
                DIRECTORY_SEPARATOR,
                '/',
                substr($source, strlen($uploadDirectory) + 1),
            ));

            try {
                $target = $collisionTargets[$source] ?? $this->webpPath($source);
                if (is_file($target)) {
                    if ($trustExisting) {
                        $targetSize = filesize($target);
                        if ($targetSize === false || $targetSize === 0) {
                            throw new RuntimeException('An existing WebP target is empty.');
                        }
                    } else {
                        $imageInfo = @getimagesize($target);
                        if ($imageInfo === false || $imageInfo[2] !== IMAGETYPE_WEBP) {
                            throw new RuntimeException('An existing WebP target is invalid.');
                        }
                    }
                    $reused++;
                } else {
                    $this->convertFile($source, $target, $quality);
                    $converted++;
                }
                if ($deleteOriginals && ! $this->isValidWebp($target)) {
                    throw new RuntimeException('The WebP target could not be fully decoded.');
                }

                $convertedPaths[$relativePath] = true;
                $convertedBasenames[strtolower(basename($relativePath))] = true;
                $originalBytes += (int) filesize($source);
                $webpBytes += (int) filesize($target);
            } catch (Throwable $exception) {
                $failures[] = $relativePath . ' :: ' . $exception->getMessage();
            }

            if ($processed % 1000 === 0 || $processed === $assignedCount) {
                CLI::write(sprintf(
                    'Worker %d processed %d / %d images.',
                    $workerIndex ?? 0,
                    $processed,
                    $assignedCount,
                ));
            }
        }

        if ($workerIndex !== null) {
            CLI::write(sprintf(
                'Worker %d complete: %d new WebP files, %d existing WebP files reused, %.2f GB converted.',
                $workerIndex,
                $converted,
                $reused,
                $originalBytes / 1024 / 1024 / 1024,
            ));

            if ($failures !== []) {
                if (file_put_contents($failureLog, implode(PHP_EOL, $failures) . PHP_EOL, LOCK_EX) === false) {
                    throw new RuntimeException('Image conversion failures occurred and the failure log could not be written.');
                }
                CLI::error(sprintf(
                    '%d images could not be converted. See %s.',
                    count($failures),
                    $failureLog,
                ));
                throw new RuntimeException('Some upload images could not be converted.');
            }

            return;
        }

        $updatedReferences = $this->updateDatabaseReferences(
            $database,
            $uploadDirectory,
            $convertedPaths,
            $convertedBasenames,
            $collisionTargetPaths,
        );

        $deleted = 0;
        if ($deleteOriginals) {
            if ($this->databaseReferencesUseOriginals(
                $database,
                $uploadDirectory,
                $convertedPaths,
                $convertedBasenames,
            )) {
                throw new RuntimeException('Some database references still point to source images; originals were preserved.');
            }

            foreach ($files as $source) {
                $relativePath = strtolower(str_replace(
                    DIRECTORY_SEPARATOR,
                    '/',
                    substr($source, strlen($uploadDirectory) + 1),
                ));
                if (! isset($convertedPaths[$relativePath])) {
                    continue;
                }

                $target = $collisionTargets[$source] ?? $this->webpPath($source);
                if (! $this->isValidWebp($target)) {
                    throw new RuntimeException("The WebP target for {$relativePath} failed final validation.");
                }
                if (! unlink($source)) {
                    throw new RuntimeException("Unable to delete the converted source image {$relativePath}.");
                }
                $deleted++;
            }
        }

        if ($failures !== []) {
            if (file_put_contents($failureLog, implode(PHP_EOL, $failures) . PHP_EOL, LOCK_EX) === false) {
                throw new RuntimeException('Image conversion failures occurred and the failure log could not be written.');
            }
        }

        CLI::write(sprintf(
            'Conversion complete: %d new WebP files, %d existing WebP files reused, %d database references updated, %d originals deleted.',
            $converted,
            $reused,
            $updatedReferences,
            $deleted,
        ));
        CLI::write(sprintf(
            'Converted source size: %.2f GB; WebP size: %.2f GB; estimated transfer reduction: %.1f%%.',
            $originalBytes / 1024 / 1024 / 1024,
            $webpBytes / 1024 / 1024 / 1024,
            $originalBytes === 0 ? 0 : (1 - $webpBytes / $originalBytes) * 100,
        ));

        if ($failures !== []) {
            CLI::error(sprintf(
                '%d images could not be converted. See %s. Their database references were not changed.',
                count($failures),
                $failureLog,
            ));
            throw new RuntimeException('Some upload images could not be converted.');
        }
    }

    /**
     * @return list<string>
     */
    private function imageFiles(string $uploadDirectory): array
    {
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($uploadDirectory, FilesystemIterator::SKIP_DOTS),
        );

        foreach ($iterator as $file) {
            if (! $file->isFile() || $file->isLink()) {
                continue;
            }

            if (in_array(strtolower($file->getExtension()), self::SOURCE_EXTENSIONS, true)) {
                $files[] = $file->getPathname();
            }
        }

        sort($files, SORT_STRING);

        return $files;
    }

    /**
     * @param list<string> $files
     * @return array<string, string>
     */
    private function collisionSafeTargets(array $files): array
    {
        $groups = [];
        foreach ($files as $file) {
            $extensionPosition = strrpos($file, '.');
            if ($extensionPosition === false) {
                continue;
            }

            $groups[strtolower(substr($file, 0, $extensionPosition))][] = $file;
        }

        $targets = [];
        foreach ($groups as $sources) {
            if (count($sources) < 2) {
                continue;
            }

            foreach ($sources as $source) {
                $targets[$source] = $source . '.webp';
            }
        }

        return $targets;
    }

    private function convertFile(string $source, string $target, int $quality): void
    {
        $imageData = file_get_contents($source);
        if ($imageData === false) {
            throw new RuntimeException('Unable to read the source image.');
        }

        $image = @imagecreatefromstring($imageData);
        unset($imageData);
        if ($image === false) {
            throw new RuntimeException('GD could not decode the source image.');
        }

        try {
            if (! imageistruecolor($image) && ! imagepalettetotruecolor($image)) {
                throw new RuntimeException('GD could not convert the palette image to true color.');
            }

            $this->applyExifOrientation($image, $source);
            imagealphablending($image, false);
            imagesavealpha($image, true);

            $temporaryTarget = $target . '.tmp-' . bin2hex(random_bytes(6));
            try {
                if (! imagewebp($image, $temporaryTarget, $quality)) {
                    throw new RuntimeException('GD could not encode the image as WebP.');
                }

                $imageInfo = @getimagesize($temporaryTarget);
                if ($imageInfo === false || $imageInfo[2] !== IMAGETYPE_WEBP) {
                    throw new RuntimeException('The generated WebP image failed verification.');
                }

                if (! rename($temporaryTarget, $target)) {
                    throw new RuntimeException('Unable to save the generated WebP image.');
                }
            } finally {
                if (is_file($temporaryTarget)) {
                    unlink($temporaryTarget);
                }
            }
        } finally {
            imagedestroy($image);
        }
    }

    private function applyExifOrientation(\GdImage &$image, string $source): void
    {
        if (! function_exists('exif_read_data')) {
            return;
        }

        $metadata = @exif_read_data($source);
        $orientation = is_array($metadata) ? (int) ($metadata['Orientation'] ?? 1) : 1;
        if ($orientation === 2) {
            imageflip($image, IMG_FLIP_HORIZONTAL);
        } elseif ($orientation === 3) {
            $this->rotateImage($image, 180);
        } elseif ($orientation === 4) {
            imageflip($image, IMG_FLIP_VERTICAL);
        } elseif ($orientation === 5 || $orientation === 7) {
            imageflip($image, IMG_FLIP_HORIZONTAL);
            $this->rotateImage($image, $orientation === 5 ? -90 : 90);
        } elseif ($orientation === 6) {
            $this->rotateImage($image, -90);
        } elseif ($orientation === 8) {
            $this->rotateImage($image, 90);
        }
    }

    private function rotateImage(\GdImage &$image, int $angle): void
    {
        $rotated = imagerotate($image, $angle, 0);
        if ($rotated === false) {
            throw new RuntimeException('Unable to apply the source image orientation.');
        }

        imagedestroy($image);
        $image = $rotated;
    }

    private function webpPath(string $source): string
    {
        return substr($source, 0, (int) strrpos($source, '.')) . '.webp';
    }

    private function isValidWebp(string $path): bool
    {
        $imageInfo = @getimagesize($path);
        if ($imageInfo === false || ($imageInfo[2] ?? null) !== IMAGETYPE_WEBP) {
            return false;
        }

        $image = @imagecreatefromwebp($path);
        if ($image === false) {
            return false;
        }

        imagedestroy($image);

        return true;
    }

    /**
     * @param array<string, true> $convertedPaths
     * @param array<string, true> $convertedBasenames
     */
    private function databaseReferencesUseOriginals(
        BaseConnection $database,
        string $uploadDirectory,
        array $convertedPaths,
        array $convertedBasenames,
    ): bool {
        foreach ($this->imageColumns($database) as [$table, $column]) {
            $rows = $database->table($table)
                ->select($column)
                ->where($column . ' !=', '')
                ->get()
                ->getResultArray();

            foreach ($rows as $row) {
                $reference = trim((string) ($row[$column] ?? ''));
                if ($reference === '' || ! preg_match('/\.(?:jpe?g|png)(?=[?#]|$)/i', $reference)) {
                    continue;
                }

                $path = $this->uploadRelativePath($reference, $uploadDirectory);
                if ($path === null) {
                    continue;
                }

                $pathKey = strtolower($path);
                if (
                    (str_contains($path, '/') && isset($convertedPaths[$pathKey]))
                    || (
                        ! str_contains($path, '/')
                        && (isset($convertedPaths[$pathKey]) || isset($convertedBasenames[strtolower(basename($path))]))
                    )
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param list<string> $files
     */
    private function reportDatabaseReferences(BaseConnection $database, string $uploadDirectory, array $files): void
    {
        $columns = $this->imageColumns($database);
        $knownPaths = [];
        $knownBasenames = [];
        foreach ($files as $file) {
            $relativePath = strtolower(str_replace(
                DIRECTORY_SEPARATOR,
                '/',
                substr($file, strlen($uploadDirectory) + 1),
            ));
            $knownPaths[$relativePath] = true;
            $knownBasenames[strtolower(basename($relativePath))] = true;
        }

        $matched = 0;
        foreach ($columns as [$table, $column]) {
            $rows = $database->table($table)
                ->select($column)
                ->where($column . ' !=', '')
                ->get()
                ->getResultArray();
            foreach ($rows as $row) {
                $reference = (string) ($row[$column] ?? '');
                $path = $this->uploadRelativePath($reference, $uploadDirectory);
                if (
                    $path !== null
                    && (isset($knownPaths[$path]) || isset($knownBasenames[strtolower(basename($path))]))
                ) {
                    $matched++;
                }
            }
        }

        CLI::write(sprintf(
            'Found %d image-related database columns and %d references pointing into uploads.',
            count($columns),
            $matched,
        ));
    }

    /**
     * @param array<string, true> $convertedPaths
     * @param array<string, true> $convertedBasenames
     * @param array<string, string> $collisionTargetPaths
     */
    private function updateDatabaseReferences(
        BaseConnection $database,
        string $uploadDirectory,
        array $convertedPaths,
        array $convertedBasenames,
        array $collisionTargetPaths,
    ): int {
        $referenceChanges = [];
        foreach ($this->imageColumns($database) as [$table, $column]) {
            $rows = $database->table($table)
                ->select($column)
                ->where($column . ' !=', '')
                ->get()
                ->getResultArray();

            foreach ($rows as $row) {
                $oldReference = trim((string) ($row[$column] ?? ''));
                if ($oldReference === '' || ! preg_match('/\.(?:jpe?g|png)(?=[?#]|$)/i', $oldReference)) {
                    continue;
                }

                $relativePath = $this->uploadRelativePath($oldReference, $uploadDirectory);
                if ($relativePath === null) {
                    continue;
                }

                $pathKey = strtolower($relativePath);
                $basenameKey = strtolower(basename($relativePath));
                $hasConvertedImage = str_contains($relativePath, '/')
                    ? isset($convertedPaths[$pathKey])
                    : isset($convertedPaths[$pathKey]) || isset($convertedBasenames[$basenameKey]);
                if (! $hasConvertedImage) {
                    continue;
                }

                $collisionTargetPath = $collisionTargetPaths[$pathKey] ?? null;
                if ($collisionTargetPath === null && ! str_contains($relativePath, '/')) {
                    $matchingCollisionPaths = array_filter(
                        $collisionTargetPaths,
                        static fn (string $targetPath, string $sourcePath): bool => strtolower(basename($sourcePath)) === $pathKey,
                        ARRAY_FILTER_USE_BOTH,
                    );
                    if (count($matchingCollisionPaths) === 1) {
                        $collisionTargetPath = reset($matchingCollisionPaths);
                    } elseif (count($matchingCollisionPaths) > 1) {
                        continue;
                    }
                }

                $replacement = $collisionTargetPath === null ? '.webp' : '$0.webp';
                $newReference = preg_replace('/\.(?:jpe?g|png)(?=([?#].*)?$)/i', $replacement, $oldReference, 1);
                if (! is_string($newReference) || $newReference === $oldReference) {
                    continue;
                }

                $referenceChanges[$table][$column][$oldReference] = $newReference;
            }
        }

        $manifestDirectory = WRITEPATH . 'backups';
        if (! is_dir($manifestDirectory) && ! mkdir($manifestDirectory, 0750, true) && ! is_dir($manifestDirectory)) {
            throw new RuntimeException('Unable to create the WebP database reference backup directory.');
        }

        $manifestPath = $manifestDirectory . DIRECTORY_SEPARATOR . 'webp-image-reference-map-' . date('Ymd-His') . '.json';
        $manifest = [
            'created_at' => date(DATE_ATOM),
            'references' => $referenceChanges,
        ];
        $manifestJson = json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        if (file_put_contents($manifestPath, $manifestJson . PHP_EOL, LOCK_EX) === false) {
            throw new RuntimeException('Unable to write the WebP database reference backup.');
        }

        $updated = 0;
        foreach ($referenceChanges as $table => $columns) {
            foreach ($columns as $column => $changes) {
                foreach ($changes as $oldReference => $newReference) {
                    if (! $database->table($table)
                        ->where($column, $oldReference)
                        ->update([$column => $newReference])) {
                        throw new RuntimeException("Unable to update image references in {$table}.{$column}.");
                    }
                    $updated += $database->affectedRows();
                }
            }
        }

        CLI::write('Database reference rollback map saved to ' . $manifestPath);

        return $updated;
    }

    /**
     * @return list<array{0: string, 1: string}>
     */
    private function imageColumns(BaseConnection $database): array
    {
        $schema = $database->getDatabase();
        $rows = $database->query(
            "SELECT TABLE_NAME, COLUMN_NAME
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = ?
               AND (
                    COLUMN_NAME LIKE '%image%'
                    OR COLUMN_NAME LIKE '%img%'
                    OR COLUMN_NAME LIKE '%photo%'
                    OR COLUMN_NAME LIKE '%picture%'
                    OR COLUMN_NAME LIKE '%thumbnail%'
                    OR COLUMN_NAME LIKE '%banner%'
                    OR COLUMN_NAME LIKE '%baner%'
               )
               AND DATA_TYPE IN ('char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext')
             ORDER BY TABLE_NAME, ORDINAL_POSITION",
            [$schema],
        )->getResultArray();

        $columns = [];
        foreach ($rows as $row) {
            $table = (string) $row['TABLE_NAME'];
            $column = (string) $row['COLUMN_NAME'];
            if (preg_match('/\A[a-zA-Z0-9_]+\z/', $table) !== 1 || preg_match('/\A[a-zA-Z0-9_]+\z/', $column) !== 1) {
                throw new RuntimeException('The database contains an unsupported image reference column name.');
            }
            $columns[] = [$table, $column];
        }

        return $columns;
    }

    private function uploadRelativePath(string $reference, string $uploadDirectory): ?string
    {
        $path = parse_url($reference, PHP_URL_PATH);
        if (! is_string($path) || $path === '') {
            return null;
        }

        $path = str_replace('\\', '/', rawurldecode($path));
        $uploadPosition = stripos($path, '/uploads/');
        if ($uploadPosition !== false) {
            $path = substr($path, $uploadPosition + strlen('/uploads/'));
        } elseif (str_starts_with(strtolower($path), 'uploads/')) {
            $path = substr($path, strlen('uploads/'));
        } elseif (str_contains($path, '://')) {
            return null;
        } else {
            $path = ltrim($path, '/');
        }

        $path = trim($path, '/');
        if ($path === '' || str_contains($path, '../') || str_starts_with($path, '..')) {
            return null;
        }

        $relativePath = strtolower($path);
        if (is_file($uploadDirectory . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path))) {
            return $relativePath;
        }

        if (! str_contains($path, '/')) {
            return $relativePath;
        }

        return null;
    }
}

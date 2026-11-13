<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

final class WebpImage
{
    public static function filename(UploadedFile $file, string $filename): string
    {
        return in_array($file->getMimeType(), ['image/jpeg', 'image/png'], true)
            ? pathinfo($filename, PATHINFO_FILENAME) . '.webp'
            : $filename;
    }

    public static function store(UploadedFile $file, string $directory, string $filename, int $quality = 82): void
    {
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the image upload directory.');
        }

        if (! in_array($file->getMimeType(), ['image/jpeg', 'image/png'], true)) {
            if (! $file->move($directory, $filename)) {
                throw new RuntimeException('Unable to save the uploaded image.');
            }

            return;
        }

        if (! function_exists('imagewebp') || ! function_exists('imagecreatefromstring')) {
            throw new RuntimeException('PHP GD with WebP support is required.');
        }

        $data = file_get_contents($file->getTempName());
        if ($data === false) {
            throw new RuntimeException('Unable to read the uploaded image.');
        }

        $image = @imagecreatefromstring($data);
        unset($data);
        if ($image === false) {
            throw new RuntimeException('Unable to decode the uploaded image.');
        }

        $target = $directory . DIRECTORY_SEPARATOR . $filename;
        $temporary = $target . '.tmp-' . bin2hex(random_bytes(6));

        try {
            if (! imageistruecolor($image) && ! imagepalettetotruecolor($image)) {
                throw new RuntimeException('Unable to convert the uploaded image to true color.');
            }
            imagealphablending($image, false);
            imagesavealpha($image, true);

            if (! imagewebp($image, $temporary, $quality)) {
                throw new RuntimeException('Unable to encode the uploaded image as WebP.');
            }

            $info = @getimagesize($temporary);
            $check = ($info !== false && ($info[2] ?? null) === IMAGETYPE_WEBP)
                ? @imagecreatefromwebp($temporary)
                : false;
            if ($check === false) {
                throw new RuntimeException('The uploaded image WebP failed verification.');
            }
            imagedestroy($check);

            if (! rename($temporary, $target)) {
                throw new RuntimeException('Unable to save the converted image.');
            }
        } finally {
            if (is_file($temporary)) {
                unlink($temporary);
            }
            imagedestroy($image);
        }
    }
}

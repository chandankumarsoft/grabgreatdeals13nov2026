<?php

namespace App\Libraries;

use InvalidArgumentException;
use RuntimeException;
use Throwable;

final class LegacyViewRenderer
{
    private const APPLICATIONS = ['frontend', 'backend'];

    /**
     * @var list<array<string, mixed>>
     */
    private array $renderDataStack = [];

    /**
     * @param array<string, mixed> $services
     */
    public function __construct(
        private readonly string $application,
        private readonly array $services = [],
    ) {
        if (! in_array($application, self::APPLICATIONS, true)) {
            throw new InvalidArgumentException('Unknown legacy view application.');
        }

        helper('url');
        helper('form');
    }

    /**
     * @param array<string, mixed> $data
     */
    public function render(string $view, array $data = []): string
    {
        $path = $this->resolveViewPath($view);
        $bufferLevel = ob_get_level();
        $serverFallbacks = [
            'HTTPS'        => '',
            'HTTP_REFERER' => base_url(),
        ];
        $originalServerValues = [];

        foreach ($serverFallbacks as $key => $fallback) {
            $originalServerValues[$key] = [
                'existed' => array_key_exists($key, $_SERVER),
                'value'   => $_SERVER[$key] ?? null,
            ];

            if (! $originalServerValues[$key]['existed']) {
                $_SERVER[$key] = $fallback;
            }
        }

        ob_start();
        $this->renderDataStack[] = $data;

        try {
            extract($data, EXTR_SKIP);
            include $path;

            return $this->prepareCsrf((string) ob_get_clean());
        } catch (Throwable $exception) {
            while (ob_get_level() > $bufferLevel) {
                ob_end_clean();
            }

            throw $exception;
        } finally {
            foreach ($originalServerValues as $key => $original) {
                if ($original['existed']) {
                    $_SERVER[$key] = $original['value'];
                } else {
                    unset($_SERVER[$key]);
                }
            }

            array_pop($this->renderDataStack);
        }
    }

    /**
     * CI3 views use this method through `$this->load->view(...)`.
     *
     * @param array<string, mixed>|string $data
     */
    public function view(string $view, array|string $data = [], bool $return = false): ?string
    {
        $inheritedData = $this->renderDataStack === []
            ? []
            : $this->renderDataStack[count($this->renderDataStack) - 1];
        $output = $this->render($view, array_replace($inheritedData, is_array($data) ? $data : []));

        if ($return) {
            return $output;
        }

        echo $output;

        return null;
    }

    public function __get(string $name): mixed
    {
        if ($name === 'load') {
            return $this;
        }

        if (! array_key_exists($name, $this->services)) {
            throw new RuntimeException("Legacy view service '{$name}' has not been configured.");
        }

        return $this->services[$name];
    }

    private function resolveViewPath(string $view): string
    {
        if (str_ends_with($view, '.php')) {
            $view = substr($view, 0, -4);
        }

        $view = str_replace('\\', '/', $view);
        $segments = explode('/', $view);

        if ($view === '' || preg_match('/\A[a-zA-Z0-9_\/-]+\z/', $view) !== 1 || in_array('..', $segments, true)) {
            throw new InvalidArgumentException('Invalid legacy view path.');
        }

        $path = ROOTPATH . 'legacy-views' . DIRECTORY_SEPARATOR
            . $this->application . DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, $segments) . '.php';

        if (! is_file($path)) {
            throw new RuntimeException("Legacy view '{$view}' was not found.");
        }

        return $path;
    }

    private function localizeProjectMedia(string $output): string
    {
        $localized = preg_replace_callback(
            '~https?://(?:www\.)?(?:seller\.)?grabgreatdeals\.com(?:\.au)?(/[^"\'\s<>]*?\.(?:jpe?g|png|gif|webp|svg|bmp|avif|ico|mp4|m4v|mov|avi|flv|wmv|webm)(?:\?[^"\'\s<>]*)?)~i',
            static fn (array $matches): string => base_url(ltrim($matches[1], '/')),
            $output,
        );

        if ($localized === null) {
            throw new RuntimeException('Unable to localize legacy project media URLs.');
        }

        return $localized;
    }

    private function prepareCsrf(string $output): string
    {
        $postFormPattern = '~<form\b([^>]*)>~i';
        $hasPostForm = preg_match_all($postFormPattern, $output, $formMatches) > 0
            && count(array_filter(
                $formMatches[1],
                static fn (string $attributes): bool => preg_match('~\bmethod\s*=\s*["\']?post["\']?\b~i', $attributes) === 1,
            )) > 0;
        $hasHead = stripos($output, '<head') !== false;
        if (! $hasPostForm && ! $hasHead) {
            return $this->localizeProjectMedia($output);
        }

        if ($hasPostForm) {
            $csrfToken = csrf_token();
            $csrfField = csrf_field();
            $output = preg_replace_callback(
                $postFormPattern,
                static function (array $matches) use ($csrfToken, $csrfField): string {
                    if (
                        preg_match('~\bmethod\s*=\s*["\']?post["\']?\b~i', $matches[1]) !== 1
                        || preg_match('~\bname\s*=\s*["\']' . preg_quote($csrfToken, '~') . '["\']~i', $matches[1]) === 1
                    ) {
                        return $matches[0];
                    }

                    return $matches[0] . $csrfField;
                },
                $output,
            );
            if ($output === null) {
                throw new RuntimeException('Unable to add CSRF fields to the legacy view.');
            }
        }

        if ($hasHead && stripos($output, 'name="csrf-token"') === false) {
            $meta = '<meta name="csrf-token" content="' . esc(csrf_hash(), 'attr') . '">';
            $output = preg_replace('~(<head\b[^>]*>)~i', '$1' . $meta, $output, 1);
            if ($output === null) {
                throw new RuntimeException('Unable to add the CSRF token to the legacy view.');
            }
        }

        if (stripos($output, '</body>') !== false) {
            $script = <<<'HTML'
<script>
if (window.jQuery) {
    jQuery.ajaxPrefilter(function (options, originalOptions, jqXHR) {
        var method = String(options.type || options.method || 'GET').toUpperCase();
        var target = new URL(options.url || window.location.href, window.location.href);
        var token = document.querySelector('meta[name="csrf-token"]');
        if (!/^(GET|HEAD|OPTIONS|TRACE)$/.test(method) && target.origin === window.location.origin && token) {
            jqXHR.setRequestHeader('X-CSRF-TOKEN', token.content);
        }
    });
}
</script>
HTML;
            $output = str_ireplace('</body>', $script . '</body>', $output);
        }

        return $this->localizeProjectMedia($output);
    }
}

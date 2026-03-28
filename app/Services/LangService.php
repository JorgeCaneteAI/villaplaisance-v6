<?php
declare(strict_types=1);

class LangService
{
    private static string $lang = DEFAULT_LANG;
    private static array  $strings = [];

    public static function init(string $lang): void
    {
        self::$lang = in_array($lang, SUPPORTED_LANGS, true) ? $lang : DEFAULT_LANG;
        $file = ROOT . '/app/Lang/' . self::$lang . '.php';
        if (file_exists($file)) {
            self::$strings = require $file;
        }
    }

    public static function get(): string
    {
        return self::$lang;
    }

    public static function t(string $key, array $replace = []): string
    {
        $value = self::$strings[$key] ?? $key;
        foreach ($replace as $k => $v) {
            $value = str_replace(':' . $k, htmlspecialchars((string)$v), $value);
        }
        return htmlspecialchars($value);
    }
}

// Helper global
function t(string $key, array $replace = []): string
{
    return LangService::t($key, $replace);
}

// Helper URL de navigation
function navUrl(string $page, string $lang): string
{
    $routes = [
        'fr' => [
            'accueil'   => '/',
            'chambres'  => '/chambres-d-hotes/',
            'villa'     => '/location-villa-provence/',
            'journal'   => '/journal/',
            'sur-place' => '/sur-place/',
            'contact'   => '/contact/',
        ],
        'en' => [
            'accueil'   => '/en/',
            'chambres'  => '/en/bed-and-breakfast/',
            'villa'     => '/en/villa-rental-provence/',
            'journal'   => '/en/journal/',
            'sur-place' => '/en/on-site/',
            'contact'   => '/en/contact/',
        ],
    ];
    return $routes[$lang][$page] ?? "/{$lang}/{$page}/";
}

<?php

/**
 * Autoloader — PSR-4-style class autoloader for Dtrans Rental
 * Maps class names to file paths within the app/ directory
 */
class Autoloader
{
    private static array $namespaceMap = [];

    public static function register(): void
    {
        self::$namespaceMap = [
            'core'        => APP_PATH . '/core/',
            'controllers' => APP_PATH . '/controllers/',
            'models'      => APP_PATH . '/models/',
            'middleware'  => APP_PATH . '/middleware/',
            'helpers'     => APP_PATH . '/helpers/',
        ];

        spl_autoload_register([self::class, 'load']);
    }

    public static function load(string $class): void
    {
        foreach (self::$namespaceMap as $dir) {
            $file = $dir . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
}

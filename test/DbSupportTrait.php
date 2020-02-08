<?php

namespace Questions\Test;

trait DbSupportTrait
{
    /** @var bool */
    private static $isInitialized;

    public static function initDatabase(): void
    {
        if (!self::$isInitialized) {
            self::resetDatabase();
        }

        self::$isInitialized = true;
    }

    public static function resetDatabase(): void
    {
        self::initializeFile(
            __DIR__ . '/resources/questions.json',
            '[]'
        );
        self::initializeFile(
            __DIR__ . '/resources/questions.csv',
            '"Question text", "Created At", "Choice 1", "Choice", "Choice 3"' . PHP_EOL
        );
    }

    private static function initializeFile(string $file, string $content): void
    {
        $handler = fopen($file, 'w+');

        ftruncate($handler, filesize($file));
        fwrite($handler, $content);
        fclose($handler);
    }
}

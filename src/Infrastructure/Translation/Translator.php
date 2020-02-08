<?php declare(strict_types=1);

namespace Questions\Infrastructure\Translation;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

class Translator implements TranslatorInterface
{
    private const LANG_DEFAULT = 'en';

    public function translate(string $text, string $toLang): string
    {
        try {
            if ($toLang === self::LANG_DEFAULT) {
                return $text;
            }

            return GoogleTranslate::trans($text, $toLang, self::LANG_DEFAULT);
        } catch (Throwable $exception) {
            return $text;
        }
    }
}

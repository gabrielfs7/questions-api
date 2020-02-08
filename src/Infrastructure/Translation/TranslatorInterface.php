<?php declare(strict_types=1);

namespace Questions\Infrastructure\Translation;

interface TranslatorInterface
{
    public const LANG_DEFAULT = 'en';

    public function translate(string $text, string $toLang): string;
}

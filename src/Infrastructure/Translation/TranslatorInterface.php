<?php declare(strict_types=1);

namespace Questions\Infrastructure\Translation;

interface TranslatorInterface
{
    public function translate(string $text, string $toLang): string;
}
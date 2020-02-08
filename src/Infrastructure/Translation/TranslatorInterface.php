<?php

namespace Questions\Infrastructure\Translation;

interface TranslatorInterface
{
    public function translate(string $text, string $toLang): string;
}
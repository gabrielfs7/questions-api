<?php declare(strict_types=1);

namespace Questions\Infrastructure\Translation;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

class Translator implements TranslatorInterface
{
    /** @var GoogleTranslate */
    private $googleTranslate;

    public function __construct(GoogleTranslate $googleTranslate)
    {
        $this->googleTranslate = $googleTranslate;
    }

    public function translate(string $text, string $toLang): string
    {
        try {
            /**
             * @TODO A cache layer and a fallback option should be developed along with a error logging mechanism.
             */
            if ($toLang === TranslatorInterface::LANG_DEFAULT) {
                return $text;
            }

            return $this->googleTranslate
                ->setTarget($toLang)
                ->translate($text);
        } catch (Throwable $exception) {
            return $text;
        }
    }
}

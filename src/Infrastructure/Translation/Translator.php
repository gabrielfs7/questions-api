<?php declare(strict_types=1);

namespace Questions\Infrastructure\Translation;

use Psr\Log\LoggerInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

class Translator implements TranslatorInterface
{
    /** @var GoogleTranslate */
    private $googleTranslate;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(GoogleTranslate $googleTranslate, LoggerInterface $logger)
    {
        $this->googleTranslate = $googleTranslate;
        $this->logger = $logger;
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
            $this->logger->warning(sprintf('Could not translate. %s', $exception->getMessage()));

            return $text;
        }
    }
}

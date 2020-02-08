<?php declare(strict_types=1);

namespace Questions\Application\Normalizer;

use Questions\Domain\Entity\Choice;
use Questions\Infrastructure\Translation\TranslatorInterface;

class ChoiceNormalizer extends AbstractNormalizer
{
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param Choice $choice
     * @return array
     */
    public function normalize($choice): array
    {
        return [
            'text' => $this->translateToLang
                ? $this->translator->translate($choice->getText(), $this->translateToLang)
                : $choice->getText(),
        ];
    }
}

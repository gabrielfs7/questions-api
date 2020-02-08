<?php declare(strict_types=1);

namespace Questions\Application\Normalizer;

use Questions\Domain\Entity\Question;
use Questions\Infrastructure\Translation\TranslatorInterface;

class QuestionNormalizer extends AbstractNormalizer
{
    /** @var ChoiceCollectionNormalizer */
    private $choiceCollectionNormalizer;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        ChoiceCollectionNormalizer $choiceCollectionNormalizer,
        TranslatorInterface $translator
    ) {
        $this->choiceCollectionNormalizer = $choiceCollectionNormalizer;
        $this->translator = $translator;
    }

    /**
     * @param Question $question
     * @return array
     */
    public function normalize($question): array
    {
        if ($this->translateToLang) {
            $this->choiceCollectionNormalizer->translateTo($this->translateToLang);
        }

        return [
            'text' => $this->translateToLang
                ? $this->translator->translate($question->getText(), $this->translateToLang)
                : $question->getText(),
            'createdAt' => $question->getCreatedAt()->format(DATE_W3C),
            'choices' => $this->choiceCollectionNormalizer->normalize($question->getChoices()),
        ];
    }
}

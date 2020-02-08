<?php

namespace Questions\Application\Normalizer;

use Questions\Domain\Entity\Question;

class QuestionNormalizer implements NormalizerInterface
{
    /**
     * @var ChoiceCollectionNormalizer
     */
    private $choiceCollectionNormalizer;

    public function __construct(ChoiceCollectionNormalizer $choiceCollectionNormalizer)
    {
        $this->choiceCollectionNormalizer = $choiceCollectionNormalizer;
    }

    /**
     * @param Question $question
     * @return array
     */
    public function normalize($question): array
    {
        return [
            'text' => $question->getText(),
            'createdAt' => $question->getCreatedAt()->format(DATE_W3C),
            'choices' => $this->choiceCollectionNormalizer->normalize($question->getChoices()),
        ];
    }
}

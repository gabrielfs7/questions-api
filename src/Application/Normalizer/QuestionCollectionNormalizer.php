<?php

namespace Questions\Application\Normalizer;

use Questions\Domain\Entity\QuestionCollection;

class QuestionCollectionNormalizer implements NormalizerInterface
{
    /** @var QuestionNormalizer */
    private $questionNormalizer;

    public function __construct(QuestionNormalizer $questionNormalizer)
    {
        $this->questionNormalizer = $questionNormalizer;
    }

    /**
     * @param QuestionCollection $questionList
     *
     * @return array
     */
    public function normalize($questionList): array
    {
        $output = [];

        foreach ($questionList as $question) {
            $output[] = $this->questionNormalizer->normalize($question);
        }

        return $output;
    }
}

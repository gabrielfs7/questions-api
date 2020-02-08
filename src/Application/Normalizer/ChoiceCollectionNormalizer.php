<?php

namespace Questions\Application\Normalizer;

use Questions\Domain\Entity\ChoiceCollection;

class ChoiceCollectionNormalizer implements NormalizerInterface
{
    /** @var ChoiceNormalizer */
    private $choiceNormalizer;

    public function __construct(ChoiceNormalizer $choiceNormalizer)
    {
        $this->choiceNormalizer = $choiceNormalizer;
    }

    /**
     * @param ChoiceCollection $choiceCollection
     *
     * @return array
     */
    public function normalize($choiceCollection): array
    {
        $output = [];

        foreach ($choiceCollection as $choice) {
            $output[] = $this->choiceNormalizer->normalize($choice);
        }

        return $output;
    }
}

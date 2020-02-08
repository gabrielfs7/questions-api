<?php

namespace Questions\Application\Normalizer;

use Questions\Domain\Entity\Choice;

class ChoiceNormalizer implements NormalizerInterface
{
    /**
     * @param Choice $choice
     * @return array
     */
    public function normalize($choice): array
    {
        return [
            'text' => $choice->getText(),
        ];
    }
}

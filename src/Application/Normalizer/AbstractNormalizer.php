<?php

namespace Questions\Application\Normalizer;

abstract class AbstractNormalizer implements NormalizerInterface
{
    /** @var string */
    protected $translateToLang;

    public function translateTo(string $lang): NormalizerInterface
    {
        $this->translateToLang = $lang;

        return $this;
    }
}

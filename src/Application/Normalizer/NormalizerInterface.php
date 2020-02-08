<?php

namespace Questions\Application\Normalizer;

interface NormalizerInterface
{
    public function translateTo(string $lang): NormalizerInterface;

    public function normalize($object): array;
}

<?php

namespace Questions\Application\Normalizer;

interface NormalizerInterface
{
    public function normalize($object): array;
}

<?php

namespace Questions\Domain\Entity;

use ArrayIterator;

class ChoiceCollection extends ArrayIterator
{
    public function __construct(Choice ...$choices)
    {
        parent::__construct($choices);
    }
}

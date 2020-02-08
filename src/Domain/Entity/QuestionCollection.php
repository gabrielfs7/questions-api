<?php

namespace Questions\Domain\Entity;

use ArrayIterator;

class QuestionCollection extends ArrayIterator
{
    public function __construct(Question ...$choices)
    {
        parent::__construct($choices);
    }
}

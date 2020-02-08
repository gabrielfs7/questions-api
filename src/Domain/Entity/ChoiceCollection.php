<?php declare(strict_types=1);

namespace Questions\Domain\Entity;

use ArrayIterator;

class ChoiceCollection extends ArrayIterator
{
    public function __construct(Choice ...$choices)
    {
        parent::__construct($choices);
    }
}

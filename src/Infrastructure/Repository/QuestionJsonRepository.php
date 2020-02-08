<?php

namespace Questions\Infrastructure\Repository;

use Questions\Domain\Entity\QuestionCollection;
use Questions\Domain\Repository\QuestionRepositoryInterface;

class QuestionJsonRepository implements QuestionRepositoryInterface
{
    public function findAll(array $criteria = []): QuestionCollection
    {
        return new QuestionCollection();
    }

    public function saveAll(QuestionCollection $collection): void
    {
    }
}

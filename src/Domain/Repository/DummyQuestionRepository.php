<?php

namespace Questions\Domain\Repository;

use Questions\Domain\Entity\QuestionCollection;

class DummyQuestionRepository implements QuestionRepositoryInterface
{
    public function findAll(array $criteria = []): QuestionCollection
    {
        return new QuestionCollection();
    }

    public function saveAll(QuestionCollection $collection): void
    {
    }
}

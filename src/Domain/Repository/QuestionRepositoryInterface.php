<?php

namespace Questions\Domain\Repository;

use Questions\Domain\Entity\QuestionCollection;

interface QuestionRepositoryInterface
{
    public function findAll(array $criteria = []): QuestionCollection;

    public function saveAll(QuestionCollection $collection): void;
}

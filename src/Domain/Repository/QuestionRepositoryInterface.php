<?php declare(strict_types=1);

namespace Questions\Domain\Repository;

use Questions\Domain\Entity\Question;
use Questions\Domain\Entity\QuestionCollection;

interface QuestionRepositoryInterface
{
    public function findAll(array $criteria = []): QuestionCollection;

    public function create(Question $question): void;
}

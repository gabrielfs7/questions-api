<?php declare(strict_types=1);

namespace Questions\Domain\Repository;

use Questions\Domain\Entity\Question;
use Questions\Domain\Entity\QuestionCollection;

class DummyQuestionRepository implements QuestionRepositoryInterface
{
    public function findAll(): QuestionCollection
    {
        return new QuestionCollection();
    }

    public function create(Question $question): void
    {
    }
}

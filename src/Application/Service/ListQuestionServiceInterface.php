<?php declare(strict_types=1);

namespace Questions\Application\Service;

use Questions\Domain\Entity\QuestionCollection;

interface ListQuestionServiceInterface
{
    public function find(): QuestionCollection;
}

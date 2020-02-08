<?php

namespace Questions\Application\Service;

use Questions\Domain\Entity\QuestionCollection;
use Questions\Domain\Repository\QuestionRepositoryInterface;

class ListQuestionService
{
    /** @var QuestionRepositoryInterface */
    private $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function find(array $criteria): QuestionCollection
    {
        return $this->questionRepository->findAll($criteria);
    }
}

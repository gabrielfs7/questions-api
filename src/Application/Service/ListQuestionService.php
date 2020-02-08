<?php declare(strict_types=1);

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

    public function find(): QuestionCollection
    {
        return $this->questionRepository->findAll();
    }
}

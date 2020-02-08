<?php

namespace Questions\Application\Service;

use DateTimeImmutable;
use Psr\Http\Message\ServerRequestInterface;
use Questions\Domain\Entity\Choice;
use Questions\Domain\Entity\ChoiceCollection;
use Questions\Domain\Entity\Question;
use Questions\Domain\Repository\QuestionRepositoryInterface;

class CreateQuestionService
{
    /** @var QuestionRepositoryInterface */
    private $repository;

    public function __construct(QuestionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(ServerRequestInterface $request): Question
    {
        //@TODO Mock for testing
        return new Question('Question 1', new ChoiceCollection(...[
            new Choice('Choice 1'),
            new Choice('Choice 2'),
            new Choice('Choice 3'),
        ]), new DateTimeImmutable('2020-02-08T07:50:45+00:00'));
    }
}

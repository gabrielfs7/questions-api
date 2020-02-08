<?php

namespace Questions\Application\Service;

use DateTimeImmutable;
use Questions\Domain\Entity\Choice;
use Questions\Domain\Entity\ChoiceCollection;
use Questions\Domain\Entity\Question;
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
        //@TODO Mock for testing
        return new QuestionCollection(new Question('Question 1', new ChoiceCollection(...[
            new Choice('Choice 1'),
            new Choice('Choice 2'),
            new Choice('Choice 3'),
        ]), new DateTimeImmutable('2020-02-08T07:50:45+00:00')));
    }
}

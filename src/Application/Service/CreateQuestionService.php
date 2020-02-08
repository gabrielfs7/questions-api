<?php

namespace Questions\Application\Service;

use Psr\Http\Message\ServerRequestInterface;
use Questions\Application\Middleware\ParseRequestMiddleware;
use Questions\Domain\Entity\Question;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\Mapper\QuestionMapperInterface;

class CreateQuestionService
{
    /** @var QuestionRepositoryInterface */
    private $repository;

    /** @var QuestionMapperInterface */
    private $questionMapper;

    public function __construct(QuestionRepositoryInterface $repository, QuestionMapperInterface $questionMapper)
    {
        $this->repository = $repository;
        $this->questionMapper = $questionMapper;
    }

    public function create(ServerRequestInterface $request): Question
    {
        $question = $this->questionMapper
            ->toObject($request->getAttribute(ParseRequestMiddleware::PARSED_REQUEST_DATA));

        $this->repository->create($question);

        return $question;
    }
}

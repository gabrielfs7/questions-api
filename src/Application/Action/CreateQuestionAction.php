<?php

namespace Questions\Application\Action;

use Questions\Application\Normalizer\QuestionNormalizer;
use Questions\Application\Service\CreateQuestionService;
use Questions\Infrastructure\Http\JsonResponseAdapter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateQuestionAction
{
    /** @var CreateQuestionService */
    private $createQuestionService;

    /** @var QuestionNormalizer */
    private $questionNormalizer;

    public function __construct(CreateQuestionService $createQuestionService, QuestionNormalizer $questionNormalizer)
    {
        $this->createQuestionService = $createQuestionService;
        $this->questionNormalizer = $questionNormalizer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $question = $this->createQuestionService->create($request);

        return (new JsonResponseAdapter(
            $response,
            200,
            $this->questionNormalizer->normalize($question)
        ))->getResponse();
    }
}

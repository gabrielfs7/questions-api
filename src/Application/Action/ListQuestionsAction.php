<?php

namespace Questions\Application\Action;

use Questions\Application\Normalizer\QuestionCollectionNormalizer;
use Questions\Application\Service\ListQuestionService;
use Questions\Infrastructure\Http\JsonResponseAdapter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListQuestionsAction
{
    /** @var ListQuestionService */
    private $listQuestionService;

    /** @var QuestionCollectionNormalizer */
    private $questionCollectionNormalizer;

    public function __construct(ListQuestionService $listQuestionService, QuestionCollectionNormalizer $questionCollectionNormalizer)
    {
        $this->listQuestionService = $listQuestionService;
        $this->questionCollectionNormalizer = $questionCollectionNormalizer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $uriParams): ResponseInterface
    {
        $questions = $this->listQuestionService->find($uriParams);

        return (new JsonResponseAdapter(
            $response,
            200,
            $this->questionCollectionNormalizer->normalize($questions)
        ))->getResponse();
    }
}

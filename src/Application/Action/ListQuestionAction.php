<?php declare(strict_types=1);

namespace Questions\Application\Action;

use Questions\Application\Normalizer\QuestionCollectionNormalizer;
use Questions\Application\Request\Validator\ListQuestionRequestValidator;
use Questions\Application\Service\ListQuestionService;
use Questions\Infrastructure\Http\JsonResponseAdapter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListQuestionAction
{
    /** @var ListQuestionRequestValidator */
    private $listQuestionRequestValidator;

    /** @var ListQuestionService */
    private $listQuestionService;

    /** @var QuestionCollectionNormalizer */
    private $questionCollectionNormalizer;

    public function __construct(
        ListQuestionRequestValidator $listQuestionRequestValidator,
        ListQuestionService $listQuestionService,
        QuestionCollectionNormalizer $questionCollectionNormalizer
    )
    {
        $this->listQuestionRequestValidator = $listQuestionRequestValidator;
        $this->listQuestionService = $listQuestionService;
        $this->questionCollectionNormalizer = $questionCollectionNormalizer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $uriParams): ResponseInterface
    {
        $this->listQuestionRequestValidator->validate($request);

        $questions = $this->questionCollectionNormalizer
            ->translateTo($request->getQueryParams()['lang'])
            ->normalize($this->listQuestionService->find());

        return (new JsonResponseAdapter(
            $response,
            200,
            $questions
        ))->getResponse();
    }
}

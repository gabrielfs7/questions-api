<?php declare(strict_types=1);

namespace Questions\Application\Action;

use Questions\Application\Normalizer\NormalizerInterface;
use Questions\Application\Request\Validator\RequestValidatorInterface;
use Questions\Application\Service\ListQuestionServiceInterface;
use Questions\Infrastructure\Http\JsonResponseAdapter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListQuestionAction implements ActionInterface
{
    /** @var RequestValidatorInterface */
    private $listQuestionRequestValidator;

    /** @var ListQuestionServiceInterface */
    private $listQuestionService;

    /** @var NormalizerInterface */
    private $questionCollectionNormalizer;

    public function __construct(
        RequestValidatorInterface $listQuestionRequestValidator,
        ListQuestionServiceInterface $listQuestionService,
        NormalizerInterface $questionCollectionNormalizer
    ) {
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

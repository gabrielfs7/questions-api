<?php declare(strict_types=1);

namespace Questions\Application\Action;

use Questions\Application\Normalizer\NormalizerInterface;
use Questions\Application\Request\Validator\RequestValidatorInterface;
use Questions\Application\Service\ListQuestionServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Questions\Infrastructure\Http\RequestResponderInterface;

class ListQuestionAction implements ActionInterface
{
    /** @var RequestValidatorInterface */
    private $listQuestionRequestValidator;

    /** @var RequestResponderInterface */
    private $requestResponder;

    /** @var ListQuestionServiceInterface */
    private $listQuestionService;

    /** @var NormalizerInterface */
    private $questionCollectionNormalizer;

    public function __construct(
        RequestValidatorInterface $listQuestionRequestValidator,
        RequestResponderInterface $requestResponder,
        ListQuestionServiceInterface $listQuestionService,
        NormalizerInterface $questionCollectionNormalizer
    ) {
        $this->listQuestionRequestValidator = $listQuestionRequestValidator;
        $this->requestResponder = $requestResponder;
        $this->listQuestionService = $listQuestionService;
        $this->questionCollectionNormalizer = $questionCollectionNormalizer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $uriParams): ResponseInterface
    {
        $this->listQuestionRequestValidator->validate($request);

        $questions = $this->questionCollectionNormalizer
            ->translateTo($request->getQueryParams()['lang'])
            ->normalize($this->listQuestionService->find());

        return $this->requestResponder
            ->respond($request, 200, $questions);
    }
}

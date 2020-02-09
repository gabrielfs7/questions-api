<?php declare(strict_types=1);

namespace Questions\Application\Action;

use Questions\Application\Normalizer\NormalizerInterface;
use Questions\Application\Request\Validator\RequestValidatorInterface;
use Questions\Application\Service\CreateQuestionServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Questions\Infrastructure\Http\RequestResponderInterface;

class CreateQuestionAction implements ActionInterface
{
    /** @var RequestValidatorInterface */
    private $questionRequestValidator;

    /** @var RequestResponderInterface */
    private $requestResponder;

    /** @var CreateQuestionServiceInterface */
    private $createQuestionService;

    /** @var NormalizerInterface */
    private $questionNormalizer;

    public function __construct(
        RequestValidatorInterface $questionRequestValidator,
        RequestResponderInterface $requestResponder,
        CreateQuestionServiceInterface $createQuestionService,
        NormalizerInterface $questionNormalizer
    ) {
        $this->questionRequestValidator = $questionRequestValidator;
        $this->requestResponder = $requestResponder;
        $this->createQuestionService = $createQuestionService;
        $this->questionNormalizer = $questionNormalizer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $uriParams): ResponseInterface
    {
        $this->questionRequestValidator->validate($request);

        $question = $this->createQuestionService->create($request);

        return $this->requestResponder
            ->respond($request, 200, $this->questionNormalizer->normalize($question));
    }
}

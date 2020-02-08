<?php declare(strict_types=1);

namespace Questions\Application\Action;

use Questions\Application\Normalizer\NormalizerInterface;
use Questions\Application\Request\Validator\RequestValidatorInterface;
use Questions\Application\Service\CreateQuestionServiceInterface;
use Questions\Infrastructure\Http\JsonResponseAdapter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateQuestionAction implements ActionInterface
{
    /** @var RequestValidatorInterface */
    private $questionRequestValidator;

    /** @var CreateQuestionServiceInterface */
    private $createQuestionService;

    /** @var NormalizerInterface */
    private $questionNormalizer;

    public function __construct(
        RequestValidatorInterface $questionRequestValidator,
        CreateQuestionServiceInterface $createQuestionService,
        NormalizerInterface $questionNormalizer
    ) {
        $this->questionRequestValidator = $questionRequestValidator;
        $this->createQuestionService = $createQuestionService;
        $this->questionNormalizer = $questionNormalizer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $uriParams): ResponseInterface
    {
        $this->questionRequestValidator->validate($request);

        $question = $this->createQuestionService->create($request);

        return (new JsonResponseAdapter(
            $response,
            200,
            $this->questionNormalizer->normalize($question)
        ))->getResponse();
    }
}

<?php declare(strict_types=1);

namespace Questions\Application\Action;

use Questions\Application\Normalizer\QuestionNormalizer;
use Questions\Application\Request\Validator\CreateQuestionRequestValidator;
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

    /** @var CreateQuestionRequestValidator */
    private $questionRequestValidator;

    public function __construct(
        CreateQuestionRequestValidator $questionRequestValidator,
        CreateQuestionService $createQuestionService,
        QuestionNormalizer $questionNormalizer
    ) {
        $this->questionRequestValidator = $questionRequestValidator;
        $this->createQuestionService = $createQuestionService;
        $this->questionNormalizer = $questionNormalizer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
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

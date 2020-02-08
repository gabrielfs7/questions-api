<?php

namespace Questions\Application\Middleware;

use Questions\Application\Request\Validator\QuestionRequestValidator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class QuestionSaveMiddleware implements MiddlewareInterface
{
    /** @var QuestionRequestValidator */
    private $questionRequestValidator;

    public function __construct(QuestionRequestValidator $questionRequestValidator)
    {
        $this->questionRequestValidator = $questionRequestValidator;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->questionRequestValidator->validate($request);

        return $handler->handle($request);
    }
}

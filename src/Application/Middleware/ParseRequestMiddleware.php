<?php

namespace Questions\Application\Middleware;

use Questions\Infrastructure\Http\JsonRequestParser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ParseRequestMiddleware
{
    public const JSON_REQUEST_BODY = 'jsonRequestBody';

    /** @var JsonRequestParser */
    private $jsonRequestParser;

    public function __construct(JsonRequestParser $jsonRequestParser)
    {
        $this->jsonRequestParser = $jsonRequestParser;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestBody = $this->jsonRequestParser->parse($request);

        $request = $request->withAttribute(self::JSON_REQUEST_BODY, $requestBody);

        return $handler->handle($request);
    }
}

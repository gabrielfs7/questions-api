<?php

namespace Questions\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Questions\Infrastructure\Http\RequestParserInterface;

class RequestParserMiddleware implements MiddlewareInterface
{
    public const PARSED_REQUEST_DATA = 'parsedRequestData';

    /** @var RequestParserInterface */
    private $requestParser;

    public function __construct(RequestParserInterface $requestParser)
    {
        $this->requestParser = $requestParser;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $request->withAttribute(self::PARSED_REQUEST_DATA, $this->requestParser->parse($request));

        return $handler->handle($request);
    }
}

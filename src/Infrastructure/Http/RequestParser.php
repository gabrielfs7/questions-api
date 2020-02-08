<?php

namespace Questions\Infrastructure\Http;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class RequestParser implements RequestParserInterface
{
    /** @var RequestParserInterface[] */
    private $requestParsers;

    public function __construct(RequestParserInterface ...$requestParsers)
    {
        $this->requestParsers = $requestParsers;
    }

    public function parse(ServerRequestInterface $request): array
    {
        $contentType = $request->getHeaderLine('Content-Type');

        foreach ($this->requestParsers as $requestParser) {
            if ($requestParser->isContentTypeSupported($contentType)) {
                return $requestParser->parse($request);
            }
        }

        throw new InvalidArgumentException(sprintf('Content-Type %s is not supported', $contentType));
    }

    public function isContentTypeSupported(string $contentType): bool
    {
        return true;
    }
}

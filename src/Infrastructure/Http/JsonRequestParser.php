<?php

namespace Questions\Infrastructure\Http;

use JsonException;
use Psr\Http\Message\ServerRequestInterface;

class JsonRequestParser implements RequestParserInterface
{
    public function parse(ServerRequestInterface $request): array
    {
        $body = (string)$request->getBody();

        if (empty($body)) {
            return [];
        }

        $params = json_decode($body, true);

        if (json_last_error()) {
            throw new JsonException(sprintf('Invalid JSON: %s', json_last_error_msg()));
        }

        return $params;
    }

    public function isContentTypeSupported(string $contentType): bool
    {
        return $contentType === 'application/json';
    }
}

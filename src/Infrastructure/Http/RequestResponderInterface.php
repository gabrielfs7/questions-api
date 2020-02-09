<?php declare(strict_types=1);

namespace Questions\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestResponderInterface
{
    public const DEFAULT_CONTENT_TYPE = 'application/json';

    public function respond(ServerRequestInterface $request, int $statusCode, $content): ResponseInterface;

    public function isContentTypeAccepted(string $acceptContentType): bool;
}

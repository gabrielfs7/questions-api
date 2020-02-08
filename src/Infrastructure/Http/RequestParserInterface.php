<?php declare(strict_types=1);

namespace Questions\Infrastructure\Http;

use Psr\Http\Message\ServerRequestInterface;

interface RequestParserInterface
{
    public function parse(ServerRequestInterface $request): array;

    public function isContentTypeSupported(string $contentType): bool;
}

<?php declare(strict_types=1);

namespace Questions\Application\Action;

use Questions\Application\Normalizer\NormalizerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ActionInterface
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $uriParams): ResponseInterface;
}

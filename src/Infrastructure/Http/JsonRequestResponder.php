<?php declare(strict_types=1);

namespace Questions\Infrastructure\Http;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JsonRequestResponder implements RequestResponderInterface
{
    /** @var ResponseFactoryInterface */
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function respond(ServerRequestInterface $request, int $statusCode, $content): ResponseInterface
    {
        $response = $this->responseFactory
            ->createResponse($statusCode)
            ->withAddedHeader('Content-Type', RequestResponderInterface::DEFAULT_CONTENT_TYPE);

        $response
            ->getBody()
            ->write(json_encode($content, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    public function isContentTypeAccepted(string $acceptContentType): bool
    {
        return $acceptContentType === RequestResponderInterface::DEFAULT_CONTENT_TYPE;
    }
}

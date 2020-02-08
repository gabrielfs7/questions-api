<?php declare(strict_types=1);

namespace Questions\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;

class JsonResponseAdapter
{
    /** @var ResponseInterface */
    private $response;

    public function __construct(ResponseInterface $response, int $statusCode, array $body)
    {
        $this->response = $response
            ->withStatus($statusCode)
            ->withAddedHeader('Content-Type', 'application/json');

        $this->response
            ->getBody()
            ->write(json_encode($body, JSON_UNESCAPED_UNICODE));
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}

<?php declare(strict_types=1);

namespace Questions\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Questions\Infrastructure\Http\Error\HttpAcceptNotSupportedException;

class RequestResponder implements RequestResponderInterface
{
    /** @var RequestResponderInterface[] */
    private $requestResponders;

    public function __construct(RequestResponderInterface ...$requestResponders)
    {
        $this->requestResponders = $requestResponders;
    }

    public function respond(ServerRequestInterface $request, int $statusCode, $content): ResponseInterface
    {
        $acceptHeader = $request->getHeaderLine('Accept');
        $acceptedContentType = empty($acceptHeader) ? RequestResponderInterface::DEFAULT_CONTENT_TYPE : $acceptHeader;

        foreach ($this->requestResponders as $requestResponder) {
            if ($requestResponder->isContentTypeAccepted($acceptedContentType)) {
                return $requestResponder->respond($request, $statusCode, $content);
            }
        }

        throw new HttpAcceptNotSupportedException(
            sprintf('Content Accept %s is not supported as response', $acceptHeader)
        );
    }

    public function isContentTypeAccepted(string $acceptContentType): bool
    {
        return true;
    }
}

<?php declare(strict_types=1);

namespace Questions\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestResponder implements RequestResponderInterface
{
    /** @var RequestResponderInterface */
    private $defaultRequestResponder;

    /** @var RequestResponderInterface[] */
    private $requestResponders;

    public function __construct(
        RequestResponderInterface $defaultRequestResponder,
        RequestResponderInterface ...$requestResponders
    )
    {
        $this->requestResponders = $requestResponders;
        $this->defaultRequestResponder = $defaultRequestResponder;
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

        return $this->defaultRequestResponder->respond(
            $request,
            406,
            [
                'code' => 406,
                'message' => sprintf('Content Accept %s is not supported as response', $acceptHeader),
            ]
        );
    }

    public function isContentTypeAccepted(string $acceptContentType): bool
    {
        return true;
    }
}

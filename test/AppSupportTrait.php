<?php declare(strict_types=1);

namespace Questions\Test;

use JsonException;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\UriFactory;

trait AppSupportTrait
{
    /** @var App */
    private $app;

    protected function request(
        string $method,
        string $path,
        array $query = null,
        array $body = [],
        array $headers = []
    ): ResponseInterface {
        $uri = (new UriFactory())
            ->createUri($path . '?' . ($query ? http_build_query($query) : null));

        $request = (new ServerRequestFactory())
            ->createServerRequest($method, $uri, $body);

        $request->getBody()
            ->write(json_encode($body));

        foreach ($headers as $headerKey => $headerValue) {
            $request = $request->withAddedHeader($headerKey, $headerValue);
        }

        return $this->getApp()->handle($request);
    }

    protected function assertJsonResponseContains(ResponseInterface $response, array $expected): void
    {
        $actual = $this->getParsedJsonResponse($response);

        Assert::assertEquals(json_encode($expected), json_encode($actual));
    }

    protected function assertResponseStatusCode(ResponseInterface $response, int $statusCode): void
    {
        Assert::assertSame($statusCode, $response->getStatusCode());
    }

    protected function getParsedJsonResponse(ResponseInterface $response): array
    {
        $body = (string)$response->getBody();

        $jsonBody = json_decode($body, true);

        if ($jsonBody === null) {
            throw new JsonException(sprintf('Could not part Json: %s', $body));
        }

        return $jsonBody;
    }

    private function getApp(): App
    {
        if (!$this->app) {
            require_once __DIR__ . '/bootstrap.php';

            /** @var App $app */
            $app = include __DIR__ . '/../app.php';

            $this->app = $app;

            include APP_ROOT . '/config/routes.php';
        }

        return $this->app;
    }
}

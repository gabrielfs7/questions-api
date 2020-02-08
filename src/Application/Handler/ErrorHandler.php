<?php declare(strict_types=1);

namespace Questions\Application\Handler;

use JsonException;
use Questions\Application\Request\Error\InvalidRequestException;
use Questions\Infrastructure\Http\JsonResponseAdapter;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Throwable;

class ErrorHandler implements ErrorHandlerInterface
{
    /** @var ResponseFactoryInterface */
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        /**
         * @TODO Proper error logging must be implemented
         */
        $statusCode = 500;
        $code = 0;
        $message = $displayErrorDetails ? $exception->getMessage() : 'Internal Error';

        if ($exception instanceof InvalidRequestException || $exception instanceof JsonException) {
            $statusCode = 400;
            $code = $exception->getCode();
            $message = $exception->getMessage();
        }

        if ($exception instanceof HttpNotFoundException) {
            $statusCode = 404;
            $code = $exception->getCode();
            $message = $exception->getMessage();
        }

        $response = $this->responseFactory->createResponse($statusCode);

        return (new JsonResponseAdapter(
            $response,
            $statusCode,
            [
                'code' => $code,
                'message' => $message,
            ]
        ))->getResponse();
    }
}

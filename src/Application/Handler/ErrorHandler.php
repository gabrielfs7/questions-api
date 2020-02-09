<?php declare(strict_types=1);

namespace Questions\Application\Handler;

use JsonException;
use Questions\Application\Request\Error\InvalidRequestException;
use Questions\Infrastructure\Http\Error\HttpAcceptNotSupportedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Questions\Infrastructure\Http\RequestResponderInterface;
use Slim\Exception\HttpNotFoundException;
use Throwable;

class ErrorHandler implements ErrorHandlerInterface
{
    /** @var RequestResponderInterface */
    private $requestResponder;

    public function __construct(RequestResponderInterface $requestResponder)
    {
        $this->requestResponder = $requestResponder;
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

        if ($exception instanceof HttpAcceptNotSupportedException) {
            $request = $request->withHeader('Accept', RequestResponderInterface::DEFAULT_CONTENT_TYPE);

            $statusCode = 406;
            $code = $exception->getCode();
            $message = $exception->getMessage();
        }

        return $this->requestResponder->respond(
            $request,
            $statusCode,
            [
                'code' => $code,
                'message' => $message,
            ]
        );
    }
}

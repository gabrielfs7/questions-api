<?php declare(strict_types=1);

namespace Questions\Application\Handler;

use JsonException;
use Psr\Log\LoggerInterface;
use Questions\Application\Request\Error\InvalidRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Questions\Infrastructure\Http\RequestResponderInterface;
use Slim\Exception\HttpNotFoundException;
use Throwable;

class ErrorHandler implements ErrorHandlerInterface
{
    /** @var RequestResponderInterface */
    private $requestResponder;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        RequestResponderInterface $requestResponder,
        LoggerInterface $logger
    ) {
        $this->requestResponder = $requestResponder;
        $this->logger = $logger;
    }

    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $statusCode = 500;
        $code = 500;
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

        if ($logErrors) {
            $context = [];

            if ($logErrorDetails) {
                $context['error'] = $exception->getMessage();
            }

            $this->logger->error($message, $context);
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

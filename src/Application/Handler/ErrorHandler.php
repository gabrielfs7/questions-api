<?php

namespace Questions\Application\Handler;

use Questions\Application\Request\Error\InvalidRequestException;
use Questions\Infrastructure\Http\JsonResponseAdapter;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class ErrorHandler
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
    ): ResponseInterface
    {
        $statusCode = 500;
        $code = 0;
        $message = $displayErrorDetails ? $exception->getMessage() : 'Internal Error';

        if ($exception instanceof InvalidRequestException) {
            $statusCode = 400;
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

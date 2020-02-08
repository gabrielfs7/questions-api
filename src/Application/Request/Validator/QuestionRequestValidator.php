<?php

namespace Questions\Application\Request\Validator;

use Questions\Application\Middleware\ParseRequestMiddleware;
use Questions\Application\Request\Error\InvalidRequestException;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Webmozart\Assert\Assert;

class QuestionRequestValidator implements RequestValidatorInterface
{
    public function validate(ServerRequestInterface $request): void
    {
        $params = $request->getAttribute(ParseRequestMiddleware::JSON_REQUEST_BODY);

        try {
            Assert::stringNotEmpty($params['text'] ?? null, 'Question text must be a string. %s given');
            Assert::string($params['createdAt'] ?? null, 'Question createdAt must be a date-time. %s given');
            Assert::isArray($params['choices'] ?? null, 'Question choices must be an array. %s given');
        } catch (InvalidArgumentException $exception) {
            throw new InvalidRequestException($exception->getMessage());
        }
    }
}

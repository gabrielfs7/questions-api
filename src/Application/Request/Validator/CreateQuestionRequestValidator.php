<?php declare(strict_types=1);

namespace Questions\Application\Request\Validator;

use DateTimeImmutable;
use Questions\Application\Middleware\RequestParserMiddleware;
use Questions\Application\Request\Error\InvalidRequestException;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Webmozart\Assert\Assert;

class CreateQuestionRequestValidator implements RequestValidatorInterface
{
    public function validate(ServerRequestInterface $request): void
    {
        $params = $request->getAttribute(RequestParserMiddleware::PARSED_REQUEST_DATA);

        try {
            $dateErrorMessage = 'Question createdAt must be a valid date-time. %s given';

            Assert::stringNotEmpty($params['text'] ?? null, 'Question text must be a string. %s given');
            Assert::stringNotEmpty($params['createdAt'] ?? null, $dateErrorMessage);

            if (!$this->isValidateDate($params['createdAt'])) {
                throw new InvalidArgumentException(sprintf($dateErrorMessage, $params['createdAt']));
            }

            $this->validateChoices((array)($params['choices'] ?? []));
        } catch (InvalidArgumentException $exception) {
            throw new InvalidRequestException($exception->getMessage());
        }
    }

    private function validateChoices(array $choices): void
    {
        Assert::count($choices, 3, 'Question choices be exactly 3. %s given');

        foreach ($choices as $choice) {
            Assert::stringNotEmpty($choice['text'] ?? null, 'Choice text must be a string. %s given');
        }
    }

    private function isValidateDate(string $createdAt): bool
    {
        try {
            (new DateTimeImmutable($createdAt));

            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }
}

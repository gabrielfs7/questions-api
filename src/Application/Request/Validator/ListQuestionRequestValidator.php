<?php declare(strict_types=1);

namespace Questions\Application\Request\Validator;

use Questions\Application\Request\Error\InvalidRequestException;
use Psr\Http\Message\ServerRequestInterface;

class ListQuestionRequestValidator implements RequestValidatorInterface
{
    /** @var array */
    private $allowedLanguages;

    public function __construct(array $allowedLanguages)
    {
        $this->allowedLanguages = $allowedLanguages;
    }

    public function validate(ServerRequestInterface $request): void
    {
        $params = $request->getQueryParams();
        $lang = $params['lang'] ?? null;

        if (!in_array($lang, array_keys($this->allowedLanguages))) {
            throw new InvalidRequestException(
                sprintf('Parameter lang must be a ISO-639-1 language code. %s given', $lang)
            );
        }
    }
}

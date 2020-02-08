<?php declare(strict_types=1);

namespace Questions\Application\Request\Validator;

use Psr\Http\Message\ServerRequestInterface;

interface RequestValidatorInterface
{
    public function validate(ServerRequestInterface $request): void;
}

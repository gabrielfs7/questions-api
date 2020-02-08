<?php

namespace Questions\Application\Request\Validator;

use Psr\Http\Message\ServerRequestInterface;

interface RequestValidatorInterface
{
    public function validate(ServerRequestInterface $request): void;
}

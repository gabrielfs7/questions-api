<?php declare(strict_types=1);

namespace Questions\Application\Service;

use Psr\Http\Message\ServerRequestInterface;
use Questions\Domain\Entity\Question;

interface CreateQuestionServiceInterface
{
    public function create(ServerRequestInterface $request): Question;
}

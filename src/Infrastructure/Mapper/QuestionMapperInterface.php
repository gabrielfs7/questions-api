<?php

namespace Questions\Infrastructure\Mapper;

use Questions\Domain\Entity\Question;

interface QuestionMapperInterface
{
    public function toObject(array $data): Question;

    public function toArray(Question $question): array;
}

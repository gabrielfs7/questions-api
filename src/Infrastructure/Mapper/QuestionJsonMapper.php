<?php declare(strict_types=1);

namespace Questions\Infrastructure\Mapper;

use DateTimeImmutable;
use Questions\Domain\Entity\Choice;
use Questions\Domain\Entity\ChoiceCollection;
use Questions\Domain\Entity\Question;

class QuestionJsonMapper implements QuestionMapperInterface
{
    public function toObject(array $data): Question
    {
        $choices = [];

        foreach ($data['choices'] as $choice) {
            $choices[] = new Choice($choice['text']);
        }

        return new Question(
            $data['text'],
            new ChoiceCollection(...$choices),
            new DateTimeImmutable($data['createdAt'])
        );
    }

    public function toArray(Question $question): array
    {
        $data = [
            'text' => $question->getText(),
            'createdAt' => $question->getCreatedAt()->format(DATE_ATOM),
            'choices' => []
        ];

        /** @var Choice $choice */
        foreach ($question->getChoices() as $choice) {
            $data['choices'][] = [
                'text' => $choice->getText(),
            ];
        }

        return $data;
    }
}

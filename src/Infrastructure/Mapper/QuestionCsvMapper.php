<?php declare(strict_types=1);

namespace Questions\Infrastructure\Mapper;

use DateTimeImmutable;
use Questions\Domain\Entity\Choice;
use Questions\Domain\Entity\ChoiceCollection;
use Questions\Domain\Entity\Question;

class QuestionCsvMapper implements QuestionMapperInterface
{
    public function toObject(array $data): Question
    {
        $choices = [];

        foreach (array_slice($data, 2) as $choice) {
            $choices[] = new Choice($choice);
        }

        return new Question(
            $data[0],
            new ChoiceCollection(...$choices),
            new DateTimeImmutable($data[1])
        );
    }

    public function toArray(Question $question): array
    {
        $data = [
            $question->getText(),
            $question->getCreatedAt()->format(DATE_ATOM),
        ];

        /** @var Choice $choice */
        foreach ($question->getChoices() as $choice) {
            $data[] = $choice->getText();
        }

        return $data;
    }
}

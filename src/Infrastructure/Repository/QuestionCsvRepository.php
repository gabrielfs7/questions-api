<?php

namespace Questions\Infrastructure\Repository;

use Questions\Domain\Entity\Question;
use Questions\Domain\Entity\QuestionCollection;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\Mapper\QuestionMapperInterface;

class QuestionCsvRepository implements QuestionRepositoryInterface
{
    /** @var string */
    private $filePath;

    /** @var QuestionMapperInterface */
    private $questionMapper;

    public function __construct(string $filePath, QuestionMapperInterface $questionMapper)
    {
        $this->filePath = $filePath;
        $this->questionMapper = $questionMapper;
    }

    public function findAll(array $criteria = []): QuestionCollection
    {
        $data = $this->getFileContent();

        $questions = [];

        foreach ($data as $question) {
            $questions[] = $this->questionMapper->toObject($question);
        }

        return new QuestionCollection(...$questions);
    }

    public function create(Question $question): void
    {
        $handler = fopen($this->filePath, 'r+');

        fseek($handler, 0, SEEK_END);
        fputcsv($handler, $this->questionMapper->toArray($question));
        fclose($handler);
    }

    private function getFileContent(): iterable
    {
        $handler = fopen($this->filePath, 'r');

        $headerSkipped = false;

        while ($data = fgetcsv($handler, 1000, ',')) {
            if ($headerSkipped) {
                yield $data;
            }

            $headerSkipped = true;
        }

        fclose($handler);
    }
}

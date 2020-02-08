<?php declare(strict_types=1);

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

    public function findAll(): QuestionCollection
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
        /**
         * @TODO Proper file handling should be implemented in case file is locked or write permission errors.
         */
        $handler = fopen($this->filePath, 'r+');

        fseek($handler, 0, SEEK_END);
        fputcsv($handler, $this->questionMapper->toArray($question));
        fclose($handler);
    }

    private function getFileContent(): iterable
    {
        /**
         * @TODO Proper file handling should be implemented in case file is locked or read permission errors.
         */
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

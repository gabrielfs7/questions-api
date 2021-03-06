<?php declare(strict_types=1);

namespace Questions\Infrastructure\Repository;

use Questions\Domain\Entity\Question;
use Questions\Domain\Entity\QuestionCollection;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\Mapper\QuestionMapperInterface;

class QuestionJsonRepository implements QuestionRepositoryInterface
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
        $data = $this->getFileContent();

        array_push($data, $this->questionMapper->toArray($question));

        file_put_contents($this->filePath, json_encode($data));
    }

    private function getFileContent(): array
    {
        /**
         * @TODO Proper file handling should be implemented in case file is locked or read permission errors.
         */
        $content = file_get_contents($this->filePath);

        return json_decode($content, true);
    }
}

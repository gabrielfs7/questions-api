<?php declare(strict_types=1);

namespace Questions\Application\Normalizer;

use Questions\Domain\Entity\QuestionCollection;

class QuestionCollectionNormalizer extends AbstractNormalizer
{
    /** @var QuestionNormalizer */
    private $questionNormalizer;

    public function __construct(QuestionNormalizer $questionNormalizer)
    {
        $this->questionNormalizer = $questionNormalizer;
    }

    /**
     * @param QuestionCollection $questionList
     *
     * @return array
     */
    public function normalize($questionList): array
    {
        if ($this->translateToLang) {
            $this->questionNormalizer->translateTo($this->translateToLang);
        }

        $output = [];

        foreach ($questionList as $question) {
            $output[] = $this->questionNormalizer->normalize($question);
        }

        return [
            'data' => $output
        ];
    }
}

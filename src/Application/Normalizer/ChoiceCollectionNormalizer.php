<?php declare(strict_types=1);

namespace Questions\Application\Normalizer;

use Questions\Domain\Entity\ChoiceCollection;

class ChoiceCollectionNormalizer extends AbstractNormalizer
{
    /** @var ChoiceNormalizer */
    private $choiceNormalizer;

    public function __construct(ChoiceNormalizer $choiceNormalizer)
    {
        $this->choiceNormalizer = $choiceNormalizer;
    }

    /**
     * @param ChoiceCollection $choiceCollection
     *
     * @return array
     */
    public function normalize($choiceCollection): array
    {
        $output = [];

        if ($this->translateToLang) {
            $this->choiceNormalizer->translateTo($this->translateToLang);
        }

        foreach ($choiceCollection as $choice) {
            $output[] = $this->choiceNormalizer->normalize($choice);
        }

        return $output;
    }
}

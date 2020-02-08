<?php declare(strict_types=1);

namespace Questions\Domain\Entity;

use DateTimeInterface;

class Question
{
    /** @var string */
    private $text;

    /** @var ChoiceCollection */
    private $choices;

    /** @var DateTimeInterface */
    private $createdAt;

    public function __construct(string $text, ChoiceCollection $choices, DateTimeInterface $createdAt)
    {
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->choices = $choices;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getChoices(): ChoiceCollection
    {
        return $this->choices;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }
}

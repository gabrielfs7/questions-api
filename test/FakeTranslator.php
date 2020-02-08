<?php declare(strict_types=1);

namespace Questions\Test;

use Questions\Infrastructure\Translation\TranslatorInterface;

class FakeTranslator implements TranslatorInterface
{
    public function translate(string $text, string $toLang): string
    {
        $translations = [
            'pt' => [
                'Question 1' => 'Questão 1',
                'Question 2' => 'Questão 2',
                'Choice 1_1' => 'Escolha 1_1',
                'Choice 1_2' => 'Escolha 1_2',
                'Choice 1_3' => 'Escolha 1_3',
                'Choice 2_1' => 'Escolha 2_1',
                'Choice 2_2' => 'Escolha 2_2',
                'Choice 2_3' => 'Escolha 2_3',
            ]
        ];

        if (isset($translations[$toLang])) {
            return $translations[$toLang][$text];
        }

        return $text;
    }
}

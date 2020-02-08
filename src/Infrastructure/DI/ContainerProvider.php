<?php

namespace Questions\Infrastructure\DI;

use Psr\Container\ContainerInterface;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\Repository\QuestionsCsvQuestionRepository;
use Questions\Infrastructure\Repository\QuestionsJsonQuestionRepository;

class ContainerProvider implements ContainerProviderInterface
{
    public function register(): array
    {
        return [
            QuestionRepositoryInterface::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                return new QuestionsCsvQuestionRepository();
            },

            QuestionsCsvQuestionRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                return new QuestionsCsvQuestionRepository();
            },

            QuestionsJsonQuestionRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                return new QuestionsJsonQuestionRepository();
            }
        ];
    }
}

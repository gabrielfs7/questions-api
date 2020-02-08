<?php

namespace Questions\Infrastructure\DI;

use Psr\Container\ContainerInterface;
use Questions\Domain\Repository\DummyQuestionRepository;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\Http\JsonRequestParser;
use Questions\Infrastructure\Http\RequestParser;
use Questions\Infrastructure\Http\RequestParserInterface;
use Questions\Infrastructure\Repository\QuestionCsvRepository;
use Questions\Infrastructure\Repository\QuestionJsonRepository;

class ContainerProvider implements ContainerProviderInterface
{
    public function register(): array
    {
        return [
            QuestionRepositoryInterface::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                if ($container->get('settings.dataSource') === 'csv') {
                    return $container->get(QuestionCsvRepository::class);
                }

                if ($container->get('settings.dataSource') === 'json') {
                    return $container->get(QuestionJsonRepository::class);
                }

                return new DummyQuestionRepository();
            },

            QuestionCsvRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                return new QuestionCsvRepository();
            },

            QuestionJsonRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                return new QuestionJsonRepository();
            },

            RequestParserInterface::class => static function (ContainerInterface $container): RequestParserInterface {
                return new RequestParser(
                    ...[
                        $container->get(JsonRequestParser::class),
                    ]
                );
            }
        ];
    }
}

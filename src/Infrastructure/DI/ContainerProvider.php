<?php

namespace Questions\Infrastructure\DI;

use Psr\Container\ContainerInterface;
use Questions\Application\Service\CreateQuestionService;
use Questions\Domain\Repository\DummyQuestionRepository;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\Http\JsonRequestParser;
use Questions\Infrastructure\Http\RequestParser;
use Questions\Infrastructure\Http\RequestParserInterface;
use Questions\Infrastructure\Mapper\QuestionCsvMapper;
use Questions\Infrastructure\Mapper\QuestionJsonMapper;
use Questions\Infrastructure\Repository\QuestionCsvRepository;
use Questions\Infrastructure\Repository\QuestionJsonRepository;

class ContainerProvider implements ContainerProviderInterface
{
    public function register(): array
    {
        return [
            QuestionRepositoryInterface::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                if ($container->get('settings.dataSource.type') === 'csv') {
                    return $container->get(QuestionCsvRepository::class);
                }

                if ($container->get('settings.dataSource.type') === 'json') {
                    return $container->get(QuestionJsonRepository::class);
                }

                return new DummyQuestionRepository();
            },

            QuestionCsvRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                $path = $container->get('settings.dataSource')[$container->get('settings.dataSource.type')]['path'];

                return new QuestionCsvRepository($path, $container->get(QuestionCsvMapper::class));
            },

            QuestionJsonRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                $path = $container->get('settings.dataSource')[$container->get('settings.dataSource.type')]['path'];

                return new QuestionJsonRepository($path, $container->get(QuestionJsonMapper::class));
            },

            CreateQuestionService::class => static function (ContainerInterface $container): CreateQuestionService {
                return new CreateQuestionService(
                    $container->get(QuestionRepositoryInterface::class),
                    $container->get(QuestionJsonMapper::class)
                );
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

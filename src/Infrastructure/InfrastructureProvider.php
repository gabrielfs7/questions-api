<?php declare(strict_types=1);

namespace Questions\Infrastructure;

use Psr\Container\ContainerInterface;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\DI\ContainerProviderInterface;
use Questions\Infrastructure\Http\JsonRequestParser;
use Questions\Infrastructure\Http\RequestParser;
use Questions\Infrastructure\Http\RequestParserInterface;
use Questions\Infrastructure\Mapper\QuestionCsvMapper;
use Questions\Infrastructure\Mapper\QuestionJsonMapper;
use Questions\Infrastructure\Repository\QuestionCsvRepository;
use Questions\Infrastructure\Repository\QuestionJsonRepository;
use Questions\Infrastructure\Translation\TranslatorInterface;

class InfrastructureProvider implements ContainerProviderInterface
{
    public function register(): array
    {
        return [
            RequestParserInterface::class => static function (ContainerInterface $container): RequestParserInterface {
                return new RequestParser(
                    ...[
                        $container->get(JsonRequestParser::class),
                    ]
                );
            },

            QuestionCsvRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                $path = $container->get('settings.dataSource')[$container->get('settings.dataSource.type')]['path'];

                return new QuestionCsvRepository($path, $container->get(QuestionCsvMapper::class));
            },

            QuestionJsonRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                $path = $container->get('settings.dataSource')[$container->get('settings.dataSource.type')]['path'];

                return new QuestionJsonRepository($path, $container->get(QuestionJsonMapper::class));
            },

            TranslatorInterface::class => static function (ContainerInterface $container): TranslatorInterface {
                return $container->get($container->get('settings.translatorClass'));
            },
        ];
    }
}

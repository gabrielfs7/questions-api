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
    private const DATA_SOURCE_PATH = 'dataSourcePath';

    public function register(): array
    {
        return $this->getTranslators()
            + $this->getRequestParsers()
            + $this->getRepositories()
            + $this->getPaths();
    }

    private function getTranslators(): array
    {
        return [
            TranslatorInterface::class => static function (ContainerInterface $container): TranslatorInterface {
                return $container->get($container->get('settings.translatorClass'));
            },
        ];
    }

    private function getRequestParsers(): array
    {
        return [
            RequestParserInterface::class => static function (ContainerInterface $container): RequestParserInterface {
                return new RequestParser(
                    ...[
                        $container->get(JsonRequestParser::class),
                    ]
                );
            },
        ];
    }

    private function getRepositories(): array
    {
        return [
            QuestionCsvRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                return new QuestionCsvRepository(
                    $container->get(self::DATA_SOURCE_PATH),
                    $container->get(QuestionCsvMapper::class)
                );
            },

            QuestionJsonRepository::class => static function (ContainerInterface $container): QuestionRepositoryInterface {
                return new QuestionJsonRepository(
                    $container->get(self::DATA_SOURCE_PATH),
                    $container->get(QuestionJsonMapper::class)
                );
            },
        ];
    }

    private function getPaths(): array
    {
        return [
            self::DATA_SOURCE_PATH => static function (ContainerInterface $container): string {
                return $container->get('settings.dataSource')[$container->get('settings.dataSource.type')]['path'];
            },
        ];
    }
}

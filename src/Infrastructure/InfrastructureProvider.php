<?php declare(strict_types=1);

namespace Questions\Infrastructure;

use GuzzleHttp\RequestOptions;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\SyslogHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\DI\ContainerProviderInterface;
use Questions\Infrastructure\Http\JsonRequestParser;
use Questions\Infrastructure\Http\JsonRequestResponder;
use Questions\Infrastructure\Http\RequestParser;
use Questions\Infrastructure\Http\RequestParserInterface;
use Questions\Infrastructure\Http\RequestResponder;
use Questions\Infrastructure\Http\RequestResponderInterface;
use Questions\Infrastructure\Mapper\QuestionCsvMapper;
use Questions\Infrastructure\Mapper\QuestionJsonMapper;
use Questions\Infrastructure\Repository\QuestionCsvRepository;
use Questions\Infrastructure\Repository\QuestionJsonRepository;
use Questions\Infrastructure\Translation\Translator;
use Questions\Infrastructure\Translation\TranslatorInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;

class InfrastructureProvider implements ContainerProviderInterface
{
    private const DATA_SOURCE_PATH = 'dataSourcePath';

    public function register(): array
    {
        return $this->getRequestLoggers()
            + $this->getRequestResponders()
            + $this->getTranslators()
            + $this->getRequestParsers()
            + $this->getRepositories()
            + $this->getPaths();
    }

    private function getRequestLoggers(): array
    {
        return [
            LoggerInterface::class => static function (ContainerInterface $container): LoggerInterface {
                return (new Logger('application'))
                    ->pushHandler(
                        (new SyslogHandler('questions', 'local6'))
                            ->setFormatter(new LineFormatter("%channel%.%level_name%: %message% %extra%"))
                    );
            },
        ];
    }

    private function getRequestResponders(): array
    {
        return [
            RequestResponderInterface::class => static function (ContainerInterface $container): RequestResponderInterface {
                return new RequestResponder(
                    $container->get(JsonRequestResponder::class),
                    ...[
                        $container->get(JsonRequestResponder::class)
                    ]
                );
            },

            JsonRequestResponder::class => static function (ContainerInterface $container): RequestResponderInterface {
                return new JsonRequestResponder($container->get(ResponseFactoryInterface::class));
            },
        ];
    }

    private function getTranslators(): array
    {
        return [
            GoogleTranslate::class => static function (ContainerInterface $container): GoogleTranslate {
                return new GoogleTranslate(
                    TranslatorInterface::LANG_DEFAULT,
                    TranslatorInterface::LANG_DEFAULT,
                    [
                        RequestOptions::CONNECT_TIMEOUT => $container->get('settings.translation.timeoutInSeconds')
                    ]
                );
            },

            Translator::class => static function (ContainerInterface $container): TranslatorInterface {
                return new Translator(
                    $container->get(GoogleTranslate::class),
                    $container->get(LoggerInterface::class)
                );
            },

            TranslatorInterface::class => static function (ContainerInterface $container): TranslatorInterface {
                return $container->get($container->get('settings.translation.class'));
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

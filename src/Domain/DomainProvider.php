<?php declare(strict_types=1);

namespace Questions\Domain;

use Psr\Container\ContainerInterface;
use Questions\Domain\Repository\DummyQuestionRepository;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\DI\ContainerProviderInterface;
use Questions\Infrastructure\Repository\QuestionCsvRepository;
use Questions\Infrastructure\Repository\QuestionJsonRepository;

class DomainProvider implements ContainerProviderInterface
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
        ];
    }
}

<?php declare(strict_types=1);

namespace Questions\Application;

use Psr\Container\ContainerInterface;
use Questions\Application\Action\ActionInterface;
use Questions\Application\Action\CreateQuestionAction;
use Questions\Application\Action\ListQuestionAction;
use Questions\Application\Middleware\MiddlewareInterface;
use Questions\Application\Middleware\RequestParserMiddleware;
use Questions\Application\Normalizer\ChoiceCollectionNormalizer;
use Questions\Application\Normalizer\ChoiceNormalizer;
use Questions\Application\Normalizer\QuestionCollectionNormalizer;
use Questions\Application\Normalizer\QuestionNormalizer;
use Questions\Application\Normalizer\NormalizerInterface;
use Questions\Application\Request\Validator\CreateQuestionRequestValidator;
use Questions\Application\Request\Validator\ListQuestionRequestValidator;
use Questions\Application\Request\Validator\RequestValidatorInterface;
use Questions\Application\Service\CreateQuestionService;
use Questions\Application\Service\CreateQuestionServiceInterface;
use Questions\Application\Service\ListQuestionService;
use Questions\Application\Service\ListQuestionServiceInterface;
use Questions\Domain\Repository\DummyQuestionRepository;
use Questions\Domain\Repository\QuestionRepositoryInterface;
use Questions\Infrastructure\DI\ContainerProviderInterface;
use Questions\Infrastructure\Http\RequestParserInterface;
use Questions\Infrastructure\Mapper\QuestionJsonMapper;
use Questions\Infrastructure\Repository\QuestionCsvRepository;
use Questions\Infrastructure\Repository\QuestionJsonRepository;
use Questions\Infrastructure\Translation\TranslatorInterface;

class ApplicationProvider implements ContainerProviderInterface
{
    public function register(): array
    {
        return $this->getRepositories()
            + $this->getMiddlewares()
            + $this->getValidators()
            + $this->getNormalizers()
            + $this->getServices()
            + $this->getActions();
    }

    public function getRepositories(): array
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

    private function getMiddlewares(): array
    {
        return [
            RequestParserMiddleware::class => static function (ContainerInterface $container): MiddlewareInterface {
                return new RequestParserMiddleware($container->get(RequestParserInterface::class));
            },
        ];
    }

    private function getValidators(): array
    {
        return [
            ListQuestionRequestValidator::class => static function (ContainerInterface $container): RequestValidatorInterface {
                return new ListQuestionRequestValidator($container->get('settings.languages'));
            },

            CreateQuestionRequestValidator::class => static function (ContainerInterface $container): RequestValidatorInterface {
                return new CreateQuestionRequestValidator();
            },
        ];
    }

    private function getNormalizers(): array
    {
        return [
            QuestionCollectionNormalizer::class => static function (ContainerInterface $container): NormalizerInterface {
                return new QuestionCollectionNormalizer($container->get(QuestionNormalizer::class));
            },

            ChoiceCollectionNormalizer::class => static function (ContainerInterface $container): NormalizerInterface {
                return new ChoiceCollectionNormalizer($container->get(ChoiceNormalizer::class));
            },

            QuestionNormalizer::class => static function (ContainerInterface $container): NormalizerInterface {
                return new QuestionNormalizer(
                    $container->get(ChoiceCollectionNormalizer::class),
                    $container->get(TranslatorInterface::class)
                );
            },

            ChoiceNormalizer::class => static function (ContainerInterface $container): NormalizerInterface {
                return new ChoiceNormalizer($container->get(TranslatorInterface::class));
            },
        ];
    }

    private function getServices(): array
    {
        return [
            CreateQuestionServiceInterface::class => static function (ContainerInterface $container): CreateQuestionServiceInterface {
                return new CreateQuestionService(
                    $container->get(QuestionRepositoryInterface::class),
                    $container->get(QuestionJsonMapper::class)
                );
            },

            ListQuestionServiceInterface::class => static function (ContainerInterface $container): ListQuestionServiceInterface {
                return new ListQuestionService($container->get(QuestionRepositoryInterface::class));
            },
        ];
    }

    private function getActions(): array
    {
        return [
            CreateQuestionAction::class => static function (ContainerInterface $container): ActionInterface {
                return new CreateQuestionAction(
                    $container->get(CreateQuestionRequestValidator::class),
                    $container->get(CreateQuestionServiceInterface::class),
                    $container->get(QuestionNormalizer::class)
                );
            },

            ListQuestionAction::class => static function (ContainerInterface $container): ActionInterface {
                return new ListQuestionAction(
                    $container->get(ListQuestionRequestValidator::class),
                    $container->get(ListQuestionServiceInterface::class),
                    $container->get(QuestionCollectionNormalizer::class)
                );
            }
        ];
    }
}

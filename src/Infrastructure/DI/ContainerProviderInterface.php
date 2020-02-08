<?php declare(strict_types=1);

namespace Questions\Infrastructure\DI;

interface ContainerProviderInterface
{
    public function register(): array;
}

<?php

namespace Questions\Infrastructure\DI;

interface ContainerProviderInterface
{
    public function register(): array;
}

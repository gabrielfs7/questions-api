<?php

use Questions\Application\ApplicationProvider;
use Questions\Domain\DomainProvider;
use Questions\Infrastructure\Slim\AppFactory;
use Questions\Infrastructure\InfrastructureProvider;

$providers = [
    new ApplicationProvider(),
    new DomainProvider(),
    new InfrastructureProvider(),
];

return (new AppFactory(...$providers))->create();
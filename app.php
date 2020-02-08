<?php

use Questions\Infrastructure\Slim\AppFactory;
use Questions\Infrastructure\DI\ContainerProvider;

return (new AppFactory(new ContainerProvider()))->create();
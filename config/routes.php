<?php

/** @var $app \Slim\App */

use Questions\Application\Action\ListQuestionAction;
use Questions\Application\Action\CreateQuestionAction;
use Questions\Application\Middleware\RequestParserMiddleware;

$container = $app->getContainer();

$app->get('/questions', ListQuestionAction::class);
$app->post('/questions', CreateQuestionAction::class)
    ->add($container->get(RequestParserMiddleware::class));
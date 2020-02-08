<?php

/** @var $app \Slim\App */

use Questions\Application\Action\ListQuestionsAction;
use Questions\Application\Action\CreateQuestionAction;
use Questions\Application\Middleware\ParseRequestMiddleware;

$container = $app->getContainer();

$app->add($container->get(ParseRequestMiddleware::class));

$app->get('/questions', ListQuestionsAction::class);
$app->post('/questions', CreateQuestionAction::class);
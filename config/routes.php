<?php

/** @var $app \Slim\App */

use Questions\Application\Action\ListQuestionsAction;
use Questions\Application\Action\CreateQuestionAction;
use Questions\Application\Middleware\ParseRequestMiddleware;
use Questions\Application\Middleware\QuestionSaveMiddleware;

$container = $app->getContainer();

$app->add($container->get(ParseRequestMiddleware::class));

$app->get('/questions', ListQuestionsAction::class);
$app->post('/questions', CreateQuestionAction::class)
    ->add($container->get(QuestionSaveMiddleware::class));
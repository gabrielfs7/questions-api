<?php
include __DIR__ . '/../bootstrap.php';

/** @var \Slim\App $app */
$app = require_once __DIR__ . '/../app.php';

include __DIR__ . '/../config/routes.php';

$app->run();

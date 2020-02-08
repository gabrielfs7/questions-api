<?php

define('APP_ROOT', __DIR__);
define('APP_ENV', $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'dev');

include __DIR__ . '/vendor/autoload.php';
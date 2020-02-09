<?php declare(strict_types=1);

return [
    'settings.displayErrorDetails' => true,
    'settings.logErrors' => true,
    'settings.logErrorsErrorDetails' => true,
    'settings.dataSource' => [
        'csv' => [
            'path' => __DIR__ . '/../../db/questions.csv',
        ],
        'json' => [
            'path' => __DIR__ . '/../../db/questions.json',
        ]
    ],
];
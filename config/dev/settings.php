<?php

return [
    'settings.displayErrorDetails' => true,
    'settings.dataSource.type' => 'json',
    'settings.dataSource' => [
        'csv' => [
            'path' => __DIR__ . '/../../db/questions.csv',
        ],
        'json' => [
            'path' => __DIR__ . '/../../db/questions.json',
        ]
    ],
];
<?php

return [
    'settings.displayErrorDetails' => true,
    'settings.dataSource.type' => 'json',
    'settings.dataSource' => [
        'csv' => [
            'path' => __DIR__ . '/../../test/resources/questions.csv',
        ],
        'json' => [
            'path' => __DIR__ . '/../../test/resources/questions.json',
        ]
    ],
];
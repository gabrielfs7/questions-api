<?php declare(strict_types=1);

use Questions\Test\FakeTranslator;

return [
    'settings.displayErrorDetails' => true,
    'settings.dataSource.type' => 'json',
    'settings.translation.class' => FakeTranslator::class,
    'settings.dataSource' => [
        'csv' => [
            'path' => __DIR__ . '/../../test/resources/questions.csv',
        ],
        'json' => [
            'path' => __DIR__ . '/../../test/resources/questions.json',
        ]
    ],
];
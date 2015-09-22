<?php

return [
    // View settings
    'view' => [
        'template_path' => __DIR__.'/../../src/Templates',
        'twig' => [
            'cache' => __DIR__.'/../storage/cache/twig',
            'debug' => true,
            'auto_reload' => true,
        ],
    ],
    // monolog settings
    'logger' => [
        'name' => 'app',
        'path' => __DIR__.'/../storage/log/app.log',
    ],
    'database' => [
        'dbname' => getenv('DB_DATABASE'),
        'user' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'host' => getenv('DB_HOST'),
        'driver' => getenv('DB_DRIVER'),
    ],
];

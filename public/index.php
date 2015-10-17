<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__.$_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__.'/../vendor/autoload.php';

// Load env vars
$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

// Instantiate the app
$settings = require __DIR__.'/../app/config/config.php';

$di = new SlimAura\Container($settings);

$app = new \Slim\App($di);
// Set up dependencies
require __DIR__.'/../app/config/dependencies.php';

// Register routes
require __DIR__.'/../app/config/routes.php';
// Run!
$app->run();

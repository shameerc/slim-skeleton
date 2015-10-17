<?php

$di = $app->getContainer();
// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------
// Twig
$di->set('view', function () use ($di) {
    $settings = $di->get('settings');
    $view = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);
    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($di->get('router'), $di->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
});

// Flash messages
$di->set('flash', $di->lazyNew('\Slim\Flash\Messages'));

// Set Callable Resolver
$di->set('callableResolver', new App\CallableResolver($di));

// -----------------------------------------------------------------------------
// Service factories 
// -----------------------------------------------------------------------------
// monolog
$di->params['Monolog\Logger']['name'] = $settings['logger']['name'];
$logger = $di->newInstance('Monolog\Logger');
$logger->pushProcessor(new \Monolog\Processor\UidProcessor());
$logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));
$di->set('logger', $logger);

// Lazyloading doctrine
$settings = $di->get('settings');
$config = $settings['database'];
$di->set('db', $di->lazy(['\Doctrine\DBAL\DriverManager', 'getConnection'], $config, $di->lazyNew('\Doctrine\DBAL\Configuration')));

// Model Injections
$di->params['App\Model\AbstractModel']['db'] = $di->lazyGet('db');

// Controller Injections
// Inject view and logger using setter injection
$di->setters['App\Controller\AbstractController']['setView'] = $di->get('view');
$di->setters['App\Controller\AbstractController']['setLogger'] = $di->get('logger');

// Simply pass a usermodel object 
// @TODO, Pass Services to controller instead of Models
$di->params['App\Controller\HomeController']['user'] = $di->lazyNew('App\Model\UserModel');

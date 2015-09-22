<?php

namespace App\Service;

use Aura\Di\Container as AuraContainer;
use Aura\Di\Injection\InjectionFactory;
use Aura\Di\Resolver\AutoResolver;
use Aura\Di\Resolver\Resolver;
use Aura\Di\Resolver\Reflector;
use Slim\Handlers\Error;
use Slim\Handlers\NotFound;
use Slim\Handlers\NotAllowed;
use Slim\Handlers\Strategies\RequestResponse;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\CallableResolver;
use Slim\Router;

final class Container extends AuraContainer
{
    /**
     * Default settings.
     *
     * @var array
     */
    private $defaultSettings = [
        'cookieLifetime' => '20 minutes',
        'cookiePath' => '/',
        'cookieDomain' => null,
        'cookieSecure' => false,
        'cookieHttpOnly' => false,
        'httpVersion' => '1.1',
        'responseChunkSize' => 4096,
        'outputBuffering' => 'append',
        'determineRouteBeforeAppMiddleware' => false,
    ];

    public function __construct($settings, $autoResolve = false)
    {
        $resolver = $this->newResolver($autoResolve);
        parent::__construct(new InjectionFactory($resolver));

        $this->registerDefaultServices($settings);
    }

    /**
     * Returns a new Resolver instance.
     *
     * @param bool $autoResolve Use the auto-resolver?
     *
     * @return Resolver
     */
    protected function newResolver($autoResolve = false)
    {
        if ($autoResolve) {
            return new AutoResolver(new Reflector());
        }

        return new Resolver(new Reflector());
    }

    public function registerDefaultServices($settings)
    {
        $defaultSettings = $this->defaultSettings;

        $this->set('settings', function () use ($defaultSettings, $settings) {
            return array_merge($defaultSettings, $settings);
        });

        $this->set('environment', function () {
            return new Environment($_SERVER);
        });

        $di = $this;

        $this->set('request', function () use ($di) {
            return Request::createFromEnvironment($di->get('environment'));
        });

        $this->set('response', function () use ($di) {
            $headers = new Headers(['Content-Type' => 'text/html']);
            $response = new Response(200, $headers);
            $settings = $di->get('settings');

            return $response->withProtocolVersion($settings['httpVersion']);
        });

        $this->set('router', function () {
            return new Router();
        });

        $this->set('foundHandler', function () {
            return new RequestResponse();
        });

        $this->set('errorHandler', function () {
            return new Error();
        });

        $this->set('notFoundHandler', function () {
            return new NotFound();
        });

        $this->set('notAllowedHandler', function () {
            return new NotAllowed();
        });

        $this->set('callableResolver', function () use ($di) {
            return new CallableResolver($di);
        });
    }
}

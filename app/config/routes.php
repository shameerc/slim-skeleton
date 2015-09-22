<?php

// Routes
$app->get('/', 'App\Controller\HomeController:index')
    ->setName('homepage');

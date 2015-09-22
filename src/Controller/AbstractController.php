<?php

namespace App\Controller;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;

abstract class AbstractController
{
    protected $view;
    protected $logger;

    public function setView(Twig $view)
    {
        $this->view = $view;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}

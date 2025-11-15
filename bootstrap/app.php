<?php

require_once __DIR__ . "/../vendor/autoload.php";

use DI\Container;
use Slim\Factory\AppFactory;

// Define ENV Constants
$dotenv = Dotenv\Dotenv::createImmutable(rootPath());
$dotenv->load();

// Define Container
$container = new Container();
AppFactory::setContainer($container);

// Create APP
$app = AppFactory::create();

// Add Containers
$containers = config("containers");
foreach ($containers as $name => $handler) {
  $container->set($name, $handler);
}

// Add Routes
routes($app, 'web');
routes($app, 'api');
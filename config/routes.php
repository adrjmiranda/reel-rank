<?php

use Slim\App;

function routes(App $app, string $fileName): void
{
  require_once rootPath() . "/routes/{$fileName}.php";
}
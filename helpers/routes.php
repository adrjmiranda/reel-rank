<?php

use Slim\App;

function routes(App $app, string $fileName)
{
  require_once rootPath() . "/routes/{$fileName}.php";
}
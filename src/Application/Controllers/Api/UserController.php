<?php

namespace ReelRank\Application\Controllers\Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
  public function register(Request $request, Response $response): Response
  {
    $response->getBody()->write(json_encode([
      'message' => 'Hello httpie'
    ]));
    return $response;
  }
}
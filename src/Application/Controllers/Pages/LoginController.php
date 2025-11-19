<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\BaseUser;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LoginController extends BaseUser
{
  public function index(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.login"));

    return $response;
  }
}
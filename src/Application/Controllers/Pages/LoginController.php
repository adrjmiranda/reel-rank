<?php

namespace MovieStar\Application\Controllers\Pages;

use MovieStar\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LoginController extends Controller
{
  public function index(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.login"));

    return $response;
  }
}
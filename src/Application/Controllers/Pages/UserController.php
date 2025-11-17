<?php

namespace MovieStar\Application\Controllers\Pages;

use MovieStar\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends Controller
{
  public function show(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.users.user"));

    return $response;
  }

  public function profile(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.users.profile"));

    return $response;
  }

  public function edit(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.users.edit"));

    return $response;
  }
}
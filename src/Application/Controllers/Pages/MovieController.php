<?php

namespace MovieStar\Application\Controllers\Pages;

use MovieStar\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class MovieController extends Controller
{
  public function show(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.movies.movie"));

    return $response;
  }
}
<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class MovieController extends Controller
{
  public function show(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.movies.movie"));

    return $response;
  }

  public function create(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.movies.create"));

    return $response;
  }

  public function edit(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.movies.edit"));

    return $response;
  }
}
<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends Controller
{
  public function index(Request $request, Response $response): Response
  {
    $movies = $this->movieDAO->all();
    $response->getBody()->write($this->view("pages.home", [
      'movies' => $movies
    ]));

    return $response;
  }
}
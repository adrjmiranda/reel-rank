<?php

namespace MovieStar\Application\Controllers\Pages;

use MovieStar\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TermsOfUse extends Controller
{
  public function index(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.terms-of-use"));

    return $response;
  }
}
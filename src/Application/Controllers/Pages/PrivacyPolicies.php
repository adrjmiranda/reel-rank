<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PrivacyPolicies extends Controller
{
  public function index(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.privacy-policies"));

    return $response;
  }
}
<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends Controller
{
  public function index(Request $request, Response $response, array $params): Response
  {
    $params = $request->getQueryParams() ?? [];
    $currentPage = (int) ($params['page'] ?? '');

    $limitPerPage = 1;
    $pages = $this->movieDAO->pages($limitPerPage);
    $movies = $this->movieDAO->pagination(1, $limitPerPage, []);
    if ($currentPage !== 0) {
      $movies = $this->movieDAO->pagination($currentPage, $limitPerPage, []);
    }

    $response->getBody()->write($this->view("pages.home", [
      'movies' => $movies,
      'pages' => $pages,
      'currentPage' => $currentPage === 0 ? 1 : $currentPage
    ]));

    return $response;
  }
}
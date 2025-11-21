<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use ReelRank\Domain\Entities\Movie;
use ReelRank\Domain\ValueObjects\CategoryId;
use ReelRank\Domain\ValueObjects\Description;
use ReelRank\Domain\ValueObjects\Duration;
use ReelRank\Domain\ValueObjects\Image;
use ReelRank\Domain\ValueObjects\Title;
use ReelRank\Domain\ValueObjects\TrailerUrl;
use ReelRank\Domain\ValueObjects\UserId;

class MovieController extends Controller
{
  public function show(Request $request, Response $response, array $params): Response
  {
    $id = (int) ($params['id'] ?? '');
    $movie = $this->movieDAO->findOne($id);

    if (!$movie) {
      $this->flash->set('session_message', 'O filme não existe.');
      return redirect('/');
    }

    $owner = $this->userDAO->findOne($movie->userId()->value());

    $response->getBody()->write($this->view("pages.movies.movie", [
      'movie' => $movie,
      'owner' => $owner
    ]));

    return $response;
  }

  public function create(Request $request, Response $response): Response
  {
    $categories = $this->categoryDAO->all();
    $response->getBody()->write($this->view("pages.movies.create", [
      'categories' => $categories
    ]));

    return $response;
  }

  public function store(Request $request, Response $response): Response
  {
    $data = $request->getParsedBody() ?? [];

    $sanitizeData = [
      "title" => 'trim|extspaces',
      "categoryId" => 'trim',
    ];
    if (!empty($data['duration']))
      $sanitizeData['duration'] = 'trim|extspaces';
    if (!empty($data['trailerUrl']))
      $sanitizeData['trailerUrl'] = 'trim';
    if (!empty($data['description']))
      $sanitizeData['description'] = 'trim|extspaces';
    $data = $this->sanitize->sanitize($request, $sanitizeData);

    $ruleList = [
      "title" => 'required|alphabetical',
      "categoryId" => 'required|numeric|validcategory',
    ];
    if (!empty($data['duration']))
      $ruleList['duration'] = 'numeric';
    if (!empty($data['trailerUrl']))
      $ruleList['trailerUrl'] = 'max:255';
    if (!empty($data['description']))
      $ruleList['description'] = 'max:500';
    $data = $this->validation->validate($data, $ruleList);
    if ($data === null)
      return redirectBack($request);

    $newMovie = new Movie(
      new Title($data['title']),
      new CategoryId($data['categoryId']),
      new UserId($this->userService->user()['id']),
      isset($data['duration']) ? new Duration($data['duration']) : null,
      isset($data['trailerUrl']) ? new TrailerUrl($data['trailerUrl']) : null,
      isset($data['description']) ? new Description($data['description']) : null,
    );

    $image = $this->imageService->save($request, $newMovie);
    if ($image === null)
      return redirectBack($request);

    $newMovie->setImage(new Image($image));

    $createdMovie = $this->movieDAO->createOne($newMovie);
    if (!$createdMovie) {
      $this->flash->set('session_message', 'Falha na criação do filme. Tente novamente.');
      return redirectBack($request);
    }

    $this->persistentInput->clear();
    return redirect("/filme/{$createdMovie->id()->value()}");
  }

  public function edit(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.movies.edit"));

    return $response;
  }

  public function update(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.movies.edit"));

    return $response;
  }
}
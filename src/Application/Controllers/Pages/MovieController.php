<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use ReelRank\Domain\Entities\Movie;
use ReelRank\Domain\ValueObjects\CategoryId;
use ReelRank\Domain\ValueObjects\Description;
use ReelRank\Domain\ValueObjects\Duration;
use ReelRank\Domain\ValueObjects\Id;
use ReelRank\Domain\ValueObjects\Image;
use ReelRank\Domain\ValueObjects\Title;
use ReelRank\Domain\ValueObjects\TrailerUrl;
use ReelRank\Domain\ValueObjects\UserId;
use ReelRank\Infrastructure\Message\Flash;

class MovieController extends Controller
{
  public function show(Request $request, Response $response, array $params): Response
  {
    $id = (int) ($params['id'] ?? '');
    $movie = $this->movieDAO->findOne($id);

    if (!$movie) {
      $this->flash->set('session_message', 'Filme não encontrado.', Flash::WARNING);
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

    $image = $this->imageService->save($request, 'movies', null);
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

  public function edit(Request $request, Response $response, array $params): Response
  {
    $id = (int) ($params['id'] ?? '');
    $movie = $this->movieDAO->findOne($id);

    if (!$movie) {
      $this->flash->set('session_message', 'Filme não encontrado.', Flash::WARNING);
      return redirectBack($request);
    }

    $categories = $this->categoryDAO->all();

    $response->getBody()->write($this->view("pages.movies.edit", [
      'movie' => $movie,
      'categories' => $categories
    ]));

    return $response;
  }

  public function update(Request $request, Response $response): Response
  {
    $data = $request->getParsedBody() ?? [];

    $id = (int) ($data['id'] ?? '');
    $searchedMovie = $this->movieDAO->findOne($id);

    if (!$searchedMovie) {
      $this->flash->set('session_message', 'Filme não encontrado. Tente novamente.');
      return redirect('/dashboard');
    }

    $owner = $this->userDAO->findOne($this->userService->user()['id']);
    if ($searchedMovie->userId()->value() !== $owner->id()->value()) {
      $this->flash->set('session_message', 'Não tem permissão para atualizar esse post. Tente novamente com outro post.');
      return redirect('/dashboard');
    }

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

    $uploadedFiles = $request->getUploadedFiles();
    $uploadedImage = $uploadedFiles['image'] ?? null;

    if (!empty($uploadedImage->getClientFilename())) {
      $image = $this->imageService->save($request, 'movies', $searchedMovie->image());
      if ($image === null)
        return redirectBack($request);

      $data['image'] = $image;
    }

    $data['id'] = $id;
    $updated = $this->movieDAO->updateData($id, $data);

    if (!$updated) {
      $this->flash->set('session_message', 'Falha ao tentar atualizar filme. Tente novamente.');
      return redirectBack($request);
    }

    $this->persistentInput->clear();
    $this->flash->set('session_message', 'Filme atualizado com sucesso!', Flash::SUCCESS);
    return redirect("/filme/{$id}");
  }

  public function remove(Request $request, Response $response, array $params): Response
  {
    $id = (int) ($params['id'] ?? '');
    $movieToRemove = $this->movieDAO->findOne($id);

    if (!$movieToRemove)
      return jsonResponse($response, [
        'message' => 'Filme não encontrado!',
        'status' => false
      ], 404);


    $movieImage = $movieToRemove->image()->value();

    $deleted = $this->movieDAO->deleteOne($id);

    if ($deleted) {
      $movieImagePath = rootPath()
        . DIRECTORY_SEPARATOR . 'public_html'
        . DIRECTORY_SEPARATOR . 'img'
        . DIRECTORY_SEPARATOR . 'movies'
        . DIRECTORY_SEPARATOR . $movieImage;

      if (file_exists($movieImagePath)) {
        unlink($movieImagePath);
      }
    }

    return jsonResponse($response, [
      'message' => $deleted
        ? 'Filme removido com sucesso!'
        : 'Falha ao tentar remover filme!',
      'status' => $deleted
    ], $deleted ? 200 : 500);
  }
}
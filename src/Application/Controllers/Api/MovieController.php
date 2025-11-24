<?php

namespace ReelRank\Application\Controllers\Api;

use ReelRank\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class MovieController extends Controller
{
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
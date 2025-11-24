<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use ReelRank\Domain\Entities\Review;
use ReelRank\Domain\ValueObjects\Comment;
use ReelRank\Domain\ValueObjects\MovieId;
use ReelRank\Domain\ValueObjects\Rating;
use ReelRank\Domain\ValueObjects\RatingEnum;
use ReelRank\Domain\ValueObjects\UserId;

class ReviewController extends Controller
{
  public function store(Request $request, Response $response): Response
  {
    $data = $this->sanitize->sanitize($request, [
      'movieId' => 'trim|extspaces',
      'comment' => 'trim|extspaces',
      'rating' => 'trim|extspaces',
    ]);

    $data = $this->validation->validate($data, [
      'movieId' => 'required|numeric|validmovie',
      'comment' => 'required',
      'rating' => 'required|numeric|between:1,5',
    ]);

    if ($data === null) {
      return redirectBack($request);
    }

    $userId = $this->userService->user()['id'];
    $createdReview = $this->reviewDAO->createOne(new Review(
      new Rating(RatingEnum::from($data['rating'])),
      new Comment($data['comment']),
      new UserId($userId),
      new MovieId($data['movieId'])
    ));

    if (!$createdReview) {
      $this->flash->set('session_message', 'Falha ao tentar inserir comentário na review.');
      return redirectBack($request);
    }

    $movieId = $data['movieId'];
    return redirect("/filme/{$movieId}");
  }
}
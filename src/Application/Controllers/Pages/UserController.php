<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\BaseUser;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends BaseUser
{
  public function show(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.users.user"));

    return $response;
  }

  public function profile(Request $request, Response $response): Response
  {
    $user = (object) $this->userService->user();

    $userId = $user->id;

    $reviewPosted = $this->movieDAO->count('userId', $userId, 'userId');
    $commentsMade = $this->reviewDAO->count('userId', $userId, 'userId');
    $reviewsWritten = $commentsMade;

    $userMovies = $this->movieDAO->allByField('userId', $userId);
    $commentsOnYourPosts = 0;
    foreach ($userMovies as $movie) {
      $movieId = $movie->id()->value();
      $comments = $this->reviewDAO->count('movieId', $movieId, 'movieId');
      $commentsOnYourPosts += $comments;
    }


    $response->getBody()->write($this->view("pages.users.profile", [
      'user' => $user,
      'reviewPosted' => $reviewPosted,
      'commentsMade' => $commentsMade,
      'reviewsWritten' => $reviewsWritten,
      'commentsOnYourPosts' => $commentsOnYourPosts,
    ]));

    return $response;
  }

  public function edit(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.users.edit"));

    return $response;
  }

  public function dashboard(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.users.dashboard"));

    return $response;
  }
}
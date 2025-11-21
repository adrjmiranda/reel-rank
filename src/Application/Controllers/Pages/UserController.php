<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\BaseUser;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use ReelRank\Domain\Entities\User;
use ReelRank\Domain\ValueObjects\Email;
use ReelRank\Domain\ValueObjects\FirstName;
use ReelRank\Domain\ValueObjects\LastName;

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
    $user = (object) $this->userService->user();

    $response->getBody()->write($this->view(
      "pages.users.edit",
      [
        'user' => $user
      ]
    ));

    return $response;
  }

  public function update(Request $request, Response $response): Response
  {
    $data = $request->getParsedBody() ?? [];

    $user = $this->userService->user();
    $userId = $user['id'];
    $userData = $this->userDAO->findOne($userId);

    $sanitizeData = empty($data['password']) ? [
      'firstName' => 'trim|extspaces',
      'lastName' => 'trim|extspaces',
      'bio' => 'trim|htmlspecialchars',
    ] : [
      'firstName' => 'trim|extspaces',
      'lastName' => 'trim|extspaces',
      'password' => 'nothing',
      'passwordConfirmation' => 'nothing',
      'bio' => 'trim|htmlspecialchars',
    ];
    $data = $this->sanitize->sanitize($request, $sanitizeData);

    $ruleList = empty($data['password']) ? [
      'firstName' => 'required|alphabetical',
      'lastName' => 'required|alphabetical',
      'bio' => 'max:500'
    ] : [
      'firstName' => 'required|alphabetical',
      'lastName' => 'required|alphabetical',
      'password' => 'required|min:8|max:20',
      'passwordConfirmation' => 'confirmpassword',
      'bio' => 'max:500'
    ];
    $data = $this->validation->validate($data, $ruleList);
    if ($data === null)
      return redirectBack($request);
    $image = $this->imageService->save($request, $userData);

    if ($image !== null)
      $data['image'] = $image;

    $updated = $this->userDAO->updateData($user['id'], $data);
    if (!$updated) {
      $this->flash->set('session_message', 'Falha ao tentar atualizar os dados de usuário. Tente novamente');
      return redirectBack($request);
    }

    $updatedUser = $this->userDAO->findOne($user['id']);
    $this->userService->login($updatedUser);
    return redirect('/perfil');
  }

  public function dashboard(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.users.dashboard"));
    return $response;
  }
}
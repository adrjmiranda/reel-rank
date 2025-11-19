<?php

namespace ReelRank\Application\Controllers\Pages;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use ReelRank\Application\Controllers\BaseUser;
use ReelRank\Domain\Entities\User;
use ReelRank\Domain\ValueObjects\Email;
use ReelRank\Domain\ValueObjects\FirstName;
use ReelRank\Domain\ValueObjects\LastName;
use ReelRank\Domain\ValueObjects\PasswordHash;

class RegisterController extends BaseUser
{

  public function index(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.register"));

    return $response;
  }

  public function store(Request $request, Response $response): Response
  {
    $data = $this->sanitize->sanitize($request, [
      'firstName' => 'trim|extspaces',
      'lastName' => 'trim|extspaces',
      'email' => 'trim',
      'password' => 'nothing',
      'passwordConfirmation' => 'nothing',
    ]);

    $data = $this->validation->validate($data, [
      'firstName' => 'required|alphabetical',
      'lastName' => 'required|alphabetical',
      'email' => 'email',
      'password' => 'required|min:8|max:20',
      'passwordConfirmation' => 'confirmpassword',
    ]);

    if ($data === null)
      return redirectBack($request);

    $createdUser = $this->userDAO->createOne(new User(
      new FirstName($data['firstName']),
      new LastName($data['lastName']),
      new Email($data['email']),
      new PasswordHash($data['password']),
    ));

    if (!$createdUser) {
      $this->flash->set('session_message', 'Falha ao tentar registrar usuário. Tenten novamente.');
      return redirectBack($request);
    }

    $this->userService->authentication($createdUser);

    return redirect('/perfil');
  }
}
<?php

namespace ReelRank\Application\Controllers\Pages;

use ReelRank\Application\Controllers\BaseUser;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LoginController extends BaseUser
{
  public function index(Request $request, Response $response): Response
  {
    $response->getBody()->write($this->view("pages.login"));

    return $response;
  }

  public function store(Request $request, Response $response): Response
  {
    $data = $this->sanitize->sanitize($request, [
      'email' => 'trim',
      'password' => 'nothing',
    ]);

    $data = $this->validation->validate($data, [
      'email' => 'email',
      'password' => 'required',
    ]);

    $userByEmail = $this->userDAO->findByEmail($data['email']);
    if (!$userByEmail) {
      $this->persistentInput->set('email', $data['email']);
      $this->flash->set('email', "Não existe um usuário registrado com esse email.");
      return redirectBack($request);
    }

    if (!password_verify($data['password'], $userByEmail->password()->value())) {
      $this->persistentInput->set('email', $data['email']);
      $this->persistentInput->set('password', $data['password']);
      $this->flash->set('password', "Senha incorreta.");
      return redirectBack($request);
    }

    $this->userService->login($userByEmail);
    return redirect('/');
  }
}
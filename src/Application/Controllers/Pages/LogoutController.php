<?php

namespace ReelRank\Application\Controllers\Pages;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use ReelRank\Application\Controllers\BaseUser;

class LogoutController extends BaseUser
{
  public function destroy(Request $request, Response $response): Response
  {
    $this->userService->logout();
    return redirect('/');
  }
}
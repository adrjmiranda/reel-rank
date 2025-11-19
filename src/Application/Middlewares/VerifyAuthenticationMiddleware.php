<?php

namespace ReelRank\Application\Middlewares;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReelRank\Application\Services\SessionService;
use ReelRank\Application\Services\UserService;
use ReelRank\Infrastructure\Message\Flash;

class VerifyAuthenticationMiddleware implements MiddlewareInterface
{
  public function process(Request $request, RequestHandler $handler): Response
  {
    $userService = new UserService(new SessionService());
    $authorized = $userService->isLoggedIn();
    if (!$authorized) {
      $flash = new Flash();
      $flash->set('session_message', 'Faça login para poder acessar esta página.');
      return redirect('/');
    }

    $response = $handler->handle($request);
    return $response;
  }
}
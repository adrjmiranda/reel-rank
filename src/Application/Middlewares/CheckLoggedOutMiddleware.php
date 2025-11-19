<?php

namespace ReelRank\Application\Middlewares;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReelRank\Application\Services\UserService;
use ReelRank\Infrastructure\Message\Flash;

class CheckLoggedOutMiddleware implements MiddlewareInterface
{
  public function process(Request $request, RequestHandler $handler): Response
  {
    $userService = new UserService();
    $authorized = $userService->isAuthenticated();
    if ($authorized) {
      $flash = new Flash();
      $flash->set('session_message', 'Você está logado.', Flash::WARNING);
      return redirectBack($request);
    }

    $response = $handler->handle($request);
    return $response;
  }
}
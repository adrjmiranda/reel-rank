<?php

namespace ReelRank\Application\Middlewares;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class CsrfTokenVerifyMiddleware implements MiddlewareInterface
{
  public function process(Request $request, RequestHandler $handler): Response
  {
    $data = $request->getParsedBody() ?? [];
    $csrfTokenInput = $data["csrfToken"] ?? '';
    $sessionCsrfToken = $_SESSION['CSRF_TOKEN'] ?? '';

    if (empty($csrfTokenInput) || !hash_equals($csrfTokenInput, $sessionCsrfToken))
      return redirectBack($request);

    $response = $handler->handle($request);
    return $response;
  }
}
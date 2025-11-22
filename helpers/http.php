<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function redirect(string $to): Response
{
  if (!str_starts_with($to, '/')) {
    $to = "/{$to}";
  }

  $response = new \Slim\Psr7\Response();
  return $response->withHeader('Location', $to)->withStatus(302);
}

function redirectBack(Request $request): Response
{
  $referer = $request->getHeaderLine('Referer');
  $previousPath = empty($referer) ? '/' : $referer;
  $response = new \Slim\Psr7\Response();
  return $response->withHeader('Location', $previousPath)->withStatus(302);
}

function jsonResponse(Response $response, array $data, int $code = 200): Response
{
  $response->getBody()->write(json_encode($data));
  return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
}
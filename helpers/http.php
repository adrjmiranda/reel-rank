<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function redirect(string $to): Response
{
  $response = new \Slim\Psr7\Response();
  return $response->withHeader('Location', $to)->withStatus(302);
}

function redirectBack(Request $request): Response
{
  $previousPath = $request->getHeaderLine('Referer') ?? '/';
  $response = new \Slim\Psr7\Response();
  return $response->withHeader('Location', $previousPath)->withStatus(302);
}
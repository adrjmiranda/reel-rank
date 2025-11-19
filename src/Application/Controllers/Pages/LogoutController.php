<?php

namespace ReelRank\Application\Controllers\Pages;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use ReelRank\Application\Controllers\Controller;

class LogoutController extends Controller
{
  public function destroy(Request $request, Response $response): Response
  {
    $this->sessionService->clear();
    return redirect('/');
  }
}
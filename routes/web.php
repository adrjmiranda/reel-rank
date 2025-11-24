<?php

use ReelRank\Application\Controllers\Pages\HomeController;
use ReelRank\Application\Controllers\Pages\LoginController;
use ReelRank\Application\Controllers\Pages\LogoutController;
use ReelRank\Application\Controllers\Pages\MovieController;
use ReelRank\Application\Controllers\Pages\PrivacyPolicies;
use ReelRank\Application\Controllers\Pages\RegisterController;
use ReelRank\Application\Controllers\Pages\ReviewController;
use ReelRank\Application\Controllers\Pages\TermsOfUse;
use ReelRank\Application\Controllers\Pages\UserController;
use ReelRank\Application\Middlewares\CheckLoggedOutMiddleware;
use ReelRank\Application\Middlewares\CsrfTokenVerifyMiddleware;
use ReelRank\Application\Middlewares\VerifyAuthenticationMiddleware;
use Slim\Routing\RouteCollectorProxy;

// Authentication
$app->group('/', function (RouteCollectorProxy $group) {
  $group->get('login', [LoginController::class, 'index']);
  $group->get('registrar', [RegisterController::class, 'index']);

  $group->group('', function (RouteCollectorProxy $group) {
    $group->post('login', [LoginController::class, 'store']);
    $group->post('registrar', [RegisterController::class, 'store']);
  })->addMiddleware(new CsrfTokenVerifyMiddleware());
})->addMiddleware(new CheckLoggedOutMiddleware());

// Public
$app->get('/', [HomeController::class, 'index']);
$app->get('/politicas-de-privacidade', [PrivacyPolicies::class, 'index']);
$app->get('/termos-de-uso', [TermsOfUse::class, 'index']);
$app->get('/search/filmes', [HomeController::class, 'search']);

// Movies
$app->get('/filme/{id}', [MovieController::class, 'show']);

// Users
$app->get('/usuario/{id}', [UserController::class, 'show']);

$app->group('/', function (RouteCollectorProxy $group) {
  // Movies
  $group->get('postar/filme', [MovieController::class, 'create']);
  $group->get('editar/filme/{id}', [MovieController::class, 'edit']);

  // Users
  $group->get('perfil', [UserController::class, 'profile']);
  $group->get('perfil/edit', [UserController::class, 'edit']);
  $group->get('dashboard', [UserController::class, 'dashboard']);

  $group->group('', function (RouteCollectorProxy $group) {
    // Movies
    $group->post('postar/filme', [MovieController::class, 'store']);
    $group->post('editar/filme', [MovieController::class, 'update']);
    $group->post('review/filme', [ReviewController::class, 'store']);

    // Users
    $group->post('perfil/edit', [UserController::class, 'update']);
  })->addMiddleware(new CsrfTokenVerifyMiddleware());
})->addMiddleware(new VerifyAuthenticationMiddleware());

// Auth
$app->get('/logout', [LogoutController::class, 'destroy'])->addMiddleware(new VerifyAuthenticationMiddleware());


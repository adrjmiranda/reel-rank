<?php

use ReelRank\Application\Controllers\Pages\HomeController;
use ReelRank\Application\Controllers\Pages\LoginController;
use ReelRank\Application\Controllers\Pages\MovieController;
use ReelRank\Application\Controllers\Pages\PrivacyPolicies;
use ReelRank\Application\Controllers\Pages\RegisterController;
use ReelRank\Application\Controllers\Pages\TermsOfUse;
use ReelRank\Application\Controllers\Pages\UserController;

// Public
$app->get('/', [HomeController::class, 'index']);
$app->get('/login', [LoginController::class, 'index']);
$app->get('/registrar', [RegisterController::class, 'index']);
$app->get('/politicas-de-privacidade', [PrivacyPolicies::class, 'index']);
$app->get('/termos-de-uso', [TermsOfUse::class, 'index']);

// Movies
$app->get('/filme/{id}', [MovieController::class, 'show']);
$app->get('/postar/filme', [MovieController::class, 'create']);
$app->get('/editar/filme', [MovieController::class, 'edit']);

// Users
$app->get('/usuario/{id}', [UserController::class, 'show']);
$app->get('/perfil', [UserController::class, 'profile']);
$app->get('/perfil/edit', [UserController::class, 'edit']);
$app->get('/dashboard', [UserController::class, 'dashboard']);
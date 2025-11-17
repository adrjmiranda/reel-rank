<?php

use MovieStar\Application\Controllers\Pages\HomeController;
use MovieStar\Application\Controllers\Pages\LoginController;
use MovieStar\Application\Controllers\Pages\MovieController;
use MovieStar\Application\Controllers\Pages\PrivacyPolicies;
use MovieStar\Application\Controllers\Pages\RegisterController;
use MovieStar\Application\Controllers\Pages\TermsOfUse;
use MovieStar\Application\Controllers\Pages\UserController;

// Public
$app->get('/', [HomeController::class, 'index']);
$app->get('/login', [LoginController::class, 'index']);
$app->get('/registrar', [RegisterController::class, 'index']);
$app->get('/politicas-de-privacidade', [PrivacyPolicies::class, 'index']);
$app->get('/termos-de-uso', [TermsOfUse::class, 'index']);

// Movies
$app->get('/movie/{id}', [MovieController::class, 'show']);

// Users
$app->get('/user/{id}', [UserController::class, 'show']);
$app->get('/profile/{id}', [UserController::class, 'profile']);
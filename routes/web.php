<?php

use MovieStar\Application\Controllers\Pages\HomeController;
use MovieStar\Application\Controllers\Pages\LoginController;
use MovieStar\Application\Controllers\Pages\PrivacyPolicies;
use MovieStar\Application\Controllers\Pages\RegisterController;
use MovieStar\Application\Controllers\Pages\TermsOfUse;

$app->get('/', [HomeController::class, 'index']);
$app->get('/login', [LoginController::class, 'index']);
$app->get('/registrar', [RegisterController::class, 'index']);
$app->get('/politicas-de-privacidade', [PrivacyPolicies::class, 'index']);
$app->get('/termos-de-uso', [TermsOfUse::class, 'index']);
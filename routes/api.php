<?php

use ReelRank\Application\Controllers\Api\UserController;

$app->post("/user/register", [UserController::class, 'register']);
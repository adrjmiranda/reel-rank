<?php

use ReelRank\Application\Controllers\Api\MovieController;

$app->delete("/filme/remove/{id}", [MovieController::class, 'remove']);
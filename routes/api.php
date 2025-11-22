<?php

use ReelRank\Application\Controllers\Pages\MovieController;

$app->delete("/filme/remove/{id}", [MovieController::class, 'remove']);
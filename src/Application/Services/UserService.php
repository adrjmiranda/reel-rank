<?php

namespace ReelRank\Application\Services;

use ReelRank\Domain\Entities\User;
use ReelRank\Infrastructure\Data\PersistentInput;

class UserService
{
  public function authentication(User $user): void
  {
    $_SESSION['AUTHORIZED_USER'] = [
      'id' => $user->id()->value(),
    ];

    $persistentInput = new PersistentInput();
    $persistentInput->clear();
  }

  public function isAuthenticated(): bool
  {
    $auth = $_SESSION['AUTHORIZED_USER'] ?? null;
    return $auth !== null && isset($auth['id']);
  }
}
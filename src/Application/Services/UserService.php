<?php

namespace ReelRank\Application\Services;

use ReelRank\Domain\Entities\User;
use ReelRank\Infrastructure\Data\PersistentInput;

class UserService
{
  private const string SESSION_AUTH_KEY = 'AUTHORIZED_USER';

  private SessionService $sessionService;

  public function __construct(SessionService $sessionService)
  {
    $this->sessionService = $sessionService;
  }

  public function login(User $user): void
  {
    $this->sessionService->set(self::SESSION_AUTH_KEY, [
      'id' => $user->id()->value()
    ]);

    $persistentInput = new PersistentInput();
    $persistentInput->clear();
  }

  public function logout(): void
  {
    $this->sessionService->remove(self::SESSION_AUTH_KEY);
  }

  public function isLoggedIn(): bool
  {
    $auth = $this->sessionService->get(self::SESSION_AUTH_KEY);
    return $auth !== null && isset($auth['id']);
  }
}
<?php

namespace ReelRank\Application\Services;

class SessionService
{
  public function init(): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }

  public function set(string $key, mixed $content): void
  {
    $this->init();
    $_SESSION[$key] = $content;
  }

  public function get(string $key, mixed $default = null): mixed
  {
    $this->init();
    return $_SESSION[$key] ?? $default;
  }

  public function remove(string $key): void
  {
    $this->init();
    unset($_SESSION[$key]);
  }

  public function clear(): void
  {
    $this->init();

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    session_destroy();
  }
}
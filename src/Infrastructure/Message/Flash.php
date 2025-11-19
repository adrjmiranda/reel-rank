<?php

namespace ReelRank\Infrastructure\Message;

class Flash
{
  private const string FLASH_KEY = 'FLASH_MSG_KEY';

  public const string ERROR = 'error';
  public const string SUCCESS = 'success';
  public const string WARNING = 'warning';

  public function set(string $key, string $message, string $type = 'error'): void
  {
    $_SESSION[self::FLASH_KEY][$key] = [$type, $message];
  }

  public function get(string $key): array
  {
    $messages = $_SESSION[self::FLASH_KEY] ?? [];
    $message = $messages[$key] ?? [];
    unset($_SESSION[self::FLASH_KEY][$key]);
    return $message;
  }
}
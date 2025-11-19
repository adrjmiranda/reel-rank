<?php

namespace ReelRank\Infrastructure\Data;

class PersistentInput
{
  private const string PERSISTENT_KEY = 'PERSISTENT_INPUT_KEY';

  public function set(string $field, mixed $value): void
  {
    $_SESSION[self::PERSISTENT_KEY][$field] = $value;
  }

  public function get(string $field): mixed
  {
    $inputs = $_SESSION[self::PERSISTENT_KEY] ?? [];
    $value = $inputs[$field] ?? null;
    unset($_SESSION[self::PERSISTENT_KEY][$field]);

    return $value;
  }

  public function clear(): void
  {
    unset($_SESSION[self::PERSISTENT_KEY]);
  }
}
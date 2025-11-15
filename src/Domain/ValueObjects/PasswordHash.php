<?php

namespace MovieStar\Domain\ValueObjects;

use MovieStar\Domain\Exception\EmptyPasswordException;

final class PasswordHash
{
  private string $hash;

  public function __construct(
    private string $value
  ) {
    if (empty($value))
      throw new EmptyPasswordException();

    $this->hash = password_hash($value, PASSWORD_DEFAULT);
  }

  public function value(): string
  {
    return $this->hash;
  }

  public function __tostring(): string
  {
    return $this->value();
  }
}
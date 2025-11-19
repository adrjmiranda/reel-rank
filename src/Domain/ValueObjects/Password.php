<?php

namespace ReelRank\Domain\ValueObjects;

use ReelRank\Domain\Exception\EmptyPasswordException;

final class Password
{
  public function __construct(
    private string $value
  ) {
    if (empty($value))
      throw new EmptyPasswordException();
  }

  public function value(): string
  {
    return $this->value;
  }

  public function __tostring(): string
  {
    return $this->value();
  }
}
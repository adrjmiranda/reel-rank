<?php

namespace MovieStar\Domain\ValueObjects;

use MovieStar\Domain\Exception\InvalidIdException;

class Id
{
  public function __construct(
    private int $value
  ) {
    if ($value <= 0)
      throw new InvalidIdException($value);
  }

  public function value(): int
  {
    return $this->value;
  }

  public function equals(self $id): bool
  {
    return $this->value === $id->value();
  }

  public function __tostring(): string
  {
    return (string) ($this->value ?? "");
  }
}
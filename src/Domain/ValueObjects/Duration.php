<?php

namespace MovieStar\Domain\ValueObjects;

use MovieStar\Domain\Exception\InvalidDurationException;

final class Duration
{
  public function __construct(
    private int $value
  ) {
    if ($value <= 0)
      throw new InvalidDurationException($value);
  }

  public function value(): int
  {
    return $this->value;
  }

  public function __tostring(): string
  {
    return (string) ($this->value ?? "");
  }
}
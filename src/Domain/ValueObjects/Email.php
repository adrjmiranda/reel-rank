<?php

namespace MovieStar\Domain\ValueObjects;

use MovieStar\Domain\Exception\InvalidEmailException;

final class Email
{
  public function __construct(
    private string $value
  ) {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL))
      throw new InvalidEmailException($value);
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
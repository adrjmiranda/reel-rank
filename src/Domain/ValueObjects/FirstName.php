<?php

namespace MovieStar\Domain\ValueObjects;

final class FirstName extends Name
{
  private const int MAX_LENGTH = 255;

  public function __construct(string $value)
  {
    parent::__construct($value, self::MAX_LENGTH);
  }
}
<?php

namespace MovieStar\Domain\ValueObjects;

use MovieStar\Domain\Exception\EmptyNameException;
use MovieStar\Domain\Exception\InvalidNameException;
use MovieStar\Domain\Exception\NameTooLongException;

class Name
{
  private const string PATTERN = "/^(?=.*[A-Za-zÀ-ÖØ-öø-ÿ])[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/";

  public function __construct(
    private string $value,
    private int $maxLength
  ) {
    if (empty($value))
      throw new EmptyNameException();

    if (!preg_match(self::PATTERN, $value))
      throw new InvalidNameException($value);

    if (strlen($value) > $maxLength)
      throw new NameTooLongException($maxLength);
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
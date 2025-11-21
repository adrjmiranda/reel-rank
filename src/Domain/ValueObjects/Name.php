<?php

namespace ReelRank\Domain\ValueObjects;

use ReelRank\Domain\Exception\EmptyNameException;
use ReelRank\Domain\Exception\InvalidNameException;
use ReelRank\Domain\Exception\NameTooLongException;

class Name
{
  private const string PATTERN = "/^(?=.*[A-Za-zÀ-ÖØ-öø-ÿ])[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/";

  public function __construct(
    private string $value,
    private int $maxLength = 255
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
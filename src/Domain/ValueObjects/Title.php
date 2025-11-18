<?php

namespace ReelRank\Domain\ValueObjects;

use ReelRank\Domain\Exception\TitleTooLongException;

final class Title
{
  private const int MAX_LENGTH = 255;

  public function __construct(
    private string $value
  ) {
    if (strlen($value) > self::MAX_LENGTH)
      throw new TitleTooLongException(self::MAX_LENGTH);
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
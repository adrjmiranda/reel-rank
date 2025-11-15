<?php

namespace MovieStar\Domain\ValueObjects;

use MovieStar\Domain\Exception\CommentTooLongException;

final class Comment
{
  private const int MAX_LENGTH = 500;

  public function __construct(
    private string $value
  ) {
    if (strlen($value) > self::MAX_LENGTH)
      throw new CommentTooLongException(self::MAX_LENGTH);
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
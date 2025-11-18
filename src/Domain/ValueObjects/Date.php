<?php

namespace ReelRank\Domain\ValueObjects;

use DateTimeImmutable;

abstract class Date
{
  public function __construct(
    private DateTimeImmutable $value
  ) {
  }

  public function value(): DateTimeImmutable
  {
    return $this->value;
  }

  public function __tostring(): string
  {
    return $this->value->format('Y-m-d H:i:s');
  }
}
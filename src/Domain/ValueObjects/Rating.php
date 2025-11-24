<?php

namespace ReelRank\Domain\ValueObjects;

final class Rating
{
  public function __construct(
    private RatingEnum $r = RatingEnum::One
  ) {
  }

  public function value(): int
  {
    return $this->r->value;
  }

  public function __tostring(): string
  {
    return (string) $this->value();
  }
}
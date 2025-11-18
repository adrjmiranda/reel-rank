<?php

namespace ReelRank\Domain\ValueObjects;

enum RatingEnum: int
{
  case One = 1;
  case Two = 2;
  case Three = 3;
  case Four = 4;
  case Five = 5;
}

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
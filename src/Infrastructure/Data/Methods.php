<?php

namespace ReelRank\Infrastructure\Data;

trait Methods
{
  public function nothing(mixed $value): mixed
  {
    return $value;
  }

  public function extspaces(int|string $value): string
  {
    if (\is_int($value))
      return $value;

    return preg_replace('/\s+/', ' ', $value);
  }
}
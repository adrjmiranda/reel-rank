<?php

namespace ReelRank\Infrastructure\Data;

trait Methods
{
  public function nothing(mixed $value): mixed
  {
    return $value;
  }

  public function extspaces(string $text): string
  {
    return preg_replace('/\s+/', ' ', $text);
  }
}
<?php

namespace MovieStar\Domain\ValueObjects;

final class Image
{
  private string $name;

  public function __construct(
    private string $extension
  ) {
    $this->name = bin2hex(random_bytes(64)) . ".{$extension}";
  }

  public function value(): string
  {
    return $this->name;
  }

  public function __tostring(): string
  {
    return $this->value();
  }
}
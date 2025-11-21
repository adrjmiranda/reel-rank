<?php

namespace ReelRank\Domain\ValueObjects;

use ReelRank\Domain\Exception\EmptyImageNameException;

final class Image
{
  public function __construct(
    private string $name
  ) {
    if (empty($name))
      throw new EmptyImageNameException();
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
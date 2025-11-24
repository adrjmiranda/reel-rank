<?php

namespace ReelRank\Domain\Collection;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class ReviewCollection implements IteratorAggregate
{
  private array $reviews;

  public function __construct(array $reviews)
  {
    $this->reviews = $reviews;
  }

  public function getIterator(): Traversable
  {
    return new ArrayIterator($this->reviews);
  }

  public function toArray(): array
  {
    return $this->reviews;
  }
}
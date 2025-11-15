<?php

namespace MovieStar\Domain\Collection;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class CategoryCollection implements IteratorAggregate
{
  private array $categories;

  public function __construct(array $categories)
  {
    $this->categories = $categories;
  }

  public function getIterator(): Traversable
  {
    return new ArrayIterator($this->categories);
  }
}
<?php

namespace MovieStar\Domain\Collection;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class MovieCollection implements IteratorAggregate
{
  private array $movies;

  public function __construct(array $movies)
  {
    $this->movies = $movies;
  }

  public function getIterator(): Traversable
  {
    return new ArrayIterator($this->movies);
  }
}
<?php

namespace ReelRank\Domain\Collection;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class UserCollection implements IteratorAggregate
{
  private array $users;

  public function __construct(array $users)
  {
    $this->users = $users;
  }

  public function getIterator(): Traversable
  {
    return new ArrayIterator($this->users);
  }
}
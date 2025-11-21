<?php

namespace ReelRank\Domain\Entities;

use DateTimeImmutable;
use ReelRank\Domain\ValueObjects\CreatedAt;
use ReelRank\Domain\ValueObjects\Id;
use ReelRank\Domain\ValueObjects\UpdatedAt;

abstract class Entity
{
  public function __construct(
    protected ?Id $id = null,
    protected ?CreatedAt $createdAt = null,
    protected ?UpdatedAt $updatedAt = null
  ) {
    $this->createdAt ??= new CreatedAt(new DateTimeImmutable());
    $this->updatedAt ??= new UpdatedAt(new DateTimeImmutable());
  }

  public function id(): ?Id
  {
    return $this->id;
  }

  public function createdAt(): ?CreatedAt
  {
    return $this->createdAt;
  }

  public function updatedAt(): ?UpdatedAt
  {
    return $this->updatedAt;
  }
}
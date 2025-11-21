<?php

namespace ReelRank\Domain\Entities;

use ReelRank\Domain\ValueObjects\CreatedAt;
use ReelRank\Domain\ValueObjects\Id;
use ReelRank\Domain\ValueObjects\Image;
use ReelRank\Domain\ValueObjects\Name;
use ReelRank\Domain\ValueObjects\UpdatedAt;

class Category extends Entity
{
  public function __construct(
    private Name $name,
    private ?Image $image = null,
    protected ?Id $id = null,
    protected ?CreatedAt $createdAt = null,
    protected ?UpdatedAt $updatedAt = null
  ) {
    parent::__construct($id, $createdAt, $updatedAt);
  }

  public function name(): Name
  {
    return $this->name;
  }

  public function image(): ?Image
  {
    return $this->image;
  }

  public function setImage(Image $image): void
  {
    $this->image = $image;
  }
}
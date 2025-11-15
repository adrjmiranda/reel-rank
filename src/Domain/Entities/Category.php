<?php

namespace MovieStar\Domain\Entities;

use MovieStar\Domain\ValueObjects\CreatedAt;
use MovieStar\Domain\ValueObjects\Id;
use MovieStar\Domain\ValueObjects\Image;
use MovieStar\Domain\ValueObjects\Name;
use MovieStar\Domain\ValueObjects\UpdatedAt;

class Category extends Entity
{
  public function __construct(
    private Name $name,
    private ?Id $id = null,
    private ?Image $image = null,
    private ?CreatedAt $createdAt = null,
    private ?UpdatedAt $updatedAt = null
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
}
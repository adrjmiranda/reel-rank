<?php

namespace MovieStar\Domain\Entities;

use MovieStar\Domain\ValueObjects\CategoryId;
use MovieStar\Domain\ValueObjects\CreatedAt;
use MovieStar\Domain\ValueObjects\Duration;
use MovieStar\Domain\ValueObjects\Id;
use MovieStar\Domain\ValueObjects\Image;
use MovieStar\Domain\ValueObjects\Title;
use MovieStar\Domain\ValueObjects\TrailerUrl;
use MovieStar\Domain\ValueObjects\UpdatedAt;
use MovieStar\Domain\ValueObjects\UserId;

class Movie extends Entity
{
  public function __construct(
    private Title $title,
    private CategoryId $categoryId,
    private UserId $userId,
    private ?Id $id = null,
    private ?Duration $duration = null,
    private ?Image $image = null,
    private ?TrailerUrl $trailerUrl = null,
    private ?CreatedAt $createdAt = null,
    private ?UpdatedAt $updatedAt = null
  ) {
    parent::__construct($id, $createdAt, $updatedAt);
  }

  public function title(): Title
  {
    return $this->title;
  }

  public function duration(): ?Duration
  {
    return $this->duration;
  }

  public function image(): ?Image
  {
    return $this->image;
  }

  public function trailerUrl(): ?TrailerUrl
  {
    return $this->trailerUrl;
  }

  public function categoryId(): CategoryId
  {
    return $this->categoryId;
  }

  public function userId(): UserId
  {
    return $this->userId;
  }
}
<?php

namespace ReelRank\Domain\Entities;

use ReelRank\Domain\ValueObjects\CategoryId;
use ReelRank\Domain\ValueObjects\CreatedAt;
use ReelRank\Domain\ValueObjects\Description;
use ReelRank\Domain\ValueObjects\Duration;
use ReelRank\Domain\ValueObjects\Id;
use ReelRank\Domain\ValueObjects\Image;
use ReelRank\Domain\ValueObjects\Title;
use ReelRank\Domain\ValueObjects\TrailerUrl;
use ReelRank\Domain\ValueObjects\UpdatedAt;
use ReelRank\Domain\ValueObjects\UserId;

class Movie extends Entity
{
  public function __construct(
    private Title $title,
    private CategoryId $categoryId,
    private UserId $userId,
    private ?Duration $duration = null,
    private ?TrailerUrl $trailerUrl = null,
    private ?Description $description = null,
    private ?Image $image = null,
    protected ?Id $id = null,
    protected ?CreatedAt $createdAt = null,
    protected ?UpdatedAt $updatedAt = null
  ) {
    parent::__construct($id, $createdAt, $updatedAt);
  }

  public function setId(Id $id): void
  {
    $this->id = $id;
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

  public function setImage(Image $image): void
  {
    $this->image = $image;
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

  public function description(): ?Description
  {
    return $this->description;
  }
}
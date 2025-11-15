<?php

namespace MovieStar\Domain\Entities;

use MovieStar\Domain\ValueObjects\Comment;
use MovieStar\Domain\ValueObjects\CreatedAt;
use MovieStar\Domain\ValueObjects\Id;
use MovieStar\Domain\ValueObjects\MovieId;
use MovieStar\Domain\ValueObjects\Rating;
use MovieStar\Domain\ValueObjects\UpdatedAt;
use MovieStar\Domain\ValueObjects\UserId;

class Review extends Entity
{
  public function __construct(
    private Rating $rating,
    private Comment $comment,
    private UserId $userId,
    private MovieId $movieId,
    private ?Id $id = null,
    private ?CreatedAt $createdAt = null,
    private ?UpdatedAt $updatedAt = null
  ) {
    parent::__construct($id, $createdAt, $updatedAt);
  }

  public function rating(): Rating
  {
    return $this->rating;
  }

  public function comment(): Comment
  {
    return $this->comment;
  }

  public function userId(): UserId
  {
    return $this->userId;
  }

  public function movieId(): MovieId
  {
    return $this->movieId;
  }
}
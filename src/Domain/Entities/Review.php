<?php

namespace ReelRank\Domain\Entities;

use ReelRank\Domain\ValueObjects\Comment;
use ReelRank\Domain\ValueObjects\CreatedAt;
use ReelRank\Domain\ValueObjects\Id;
use ReelRank\Domain\ValueObjects\MovieId;
use ReelRank\Domain\ValueObjects\Rating;
use ReelRank\Domain\ValueObjects\UpdatedAt;
use ReelRank\Domain\ValueObjects\UserId;

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
<?php

namespace MovieStar\Infrastructure\Interfaces;

use MovieStar\Domain\Collection\ReviewCollection;
use MovieStar\Domain\Entities\Review;

interface ReviewDAOInterface
{
  public function createOne(Review $review): ?Review;
  public function findOne(int $id, array $filter = []): ?Review;
  public function updateOne(Review $review): ?bool;
  public function deleteOne(int $id): ?bool;
  public function all(array $filter = []): ReviewCollection;
}
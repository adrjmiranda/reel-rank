<?php

namespace MovieStar\Infrastructure\Interfaces;

use MovieStar\Domain\Collection\MovieCollection;
use MovieStar\Domain\Entities\Movie;

interface MovieDAOInterface
{
  public function createOne(Movie $movie): ?Movie;
  public function findOne(int $id, array $filter = []): ?Movie;
  public function updateOne(Movie $movie): ?bool;
  public function deleteOne(int $id): ?bool;
  public function all(array $filter = []): MovieCollection;
}
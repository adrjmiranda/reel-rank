<?php

namespace ReelRank\Infrastructure\Interfaces;

use ReelRank\Domain\Collection\MovieCollection;
use ReelRank\Domain\Entities\Movie;

interface MovieDAOInterface
{
  public function createOne(Movie $movie): ?Movie;
  public function findOne(int $id, array $filter = []): ?Movie;
  public function updateOne(Movie $movie): ?bool;
  public function deleteOne(int $id): ?bool;
  public function all(array $filter = []): MovieCollection;
}
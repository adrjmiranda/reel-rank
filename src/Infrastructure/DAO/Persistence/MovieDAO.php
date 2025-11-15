<?php

namespace MovieStar\Infrastructure\DAO\Persistence;

use MovieStar\Domain\Collection\MovieCollection;
use MovieStar\Domain\Entities\Movie;
use MovieStar\Infrastructure\DAO\DAO;
use MovieStar\Infrastructure\Interfaces\MovieDAOInterface;

final class MovieDAO extends DAO implements MovieDAOInterface
{
  private const string TABLE_NAME = 'movies';

  public function __construct()
  {
    parent::__construct(self::TABLE_NAME);
  }

  public function createOne(Movie $movie): ?Movie
  {
    $lastInsertId = $this->insertRow($movie);
    return $lastInsertId ? $this->findOne($lastInsertId) : null;
  }

  public function findOne(int $id, array $filter = []): ?Movie
  {
    $data = $this->findRow($id, $filter);
    return $data ? $this->hydrate($data, Movie::class) : null;
  }

  public function updateOne(Movie $movie): ?bool
  {
    return $this->updateRow($movie);
  }

  public function deleteOne(int $id): ?bool
  {
    return $this->deleteRow($id);
  }

  public function all(array $filter = []): MovieCollection
  {
    $data = $this->findAll($filter);
    return $this->hydrateList($data, Movie::class, MovieCollection::class);
  }
}
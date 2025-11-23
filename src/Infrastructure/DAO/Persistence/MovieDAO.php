<?php

namespace ReelRank\Infrastructure\DAO\Persistence;

use PDO;
use ReelRank\Domain\Collection\MovieCollection;
use ReelRank\Domain\Entities\Movie;
use ReelRank\Infrastructure\DAO\DAO;
use ReelRank\Infrastructure\Interfaces\MovieDAOInterface;

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

  public function allByField(string $field, mixed $value, array $filter = []): MovieCollection
  {
    $data = $this->findAllByField($field, $value, $filter);
    return $this->hydrateList($data, Movie::class, MovieCollection::class);
  }

  public function rating(int $id): float
  {
    try {
      $query = "SELECT ROUND(AVG(rating), 1) AS averageRating FROM reviews WHERE movieId = :movieId";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':movieId', $id);
      $stmt->execute();

      $result = $stmt->fetchColumn();

      return $result !== null ? (float) $result : 0.0;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function pagination(int $page, int $limit, array $filter, string $orderBy = 'ASC'): MovieCollection
  {
    $data = $this->page($page, $limit, $filter, $orderBy);
    return $this->hydrateList($data, Movie::class, MovieCollection::class);
  }
}
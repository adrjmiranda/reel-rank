<?php

namespace ReelRank\Infrastructure\DAO\Persistence;

use PDO;
use ReelRank\Domain\Collection\ReviewCollection;
use ReelRank\Domain\Entities\Review;
use ReelRank\Infrastructure\DAO\DAO;
use ReelRank\Infrastructure\Interfaces\ReviewDAOInterface;

final class ReviewDAO extends DAO implements ReviewDAOInterface
{
  private const string TABLE_NAME = 'reviews';

  public function __construct()
  {
    parent::__construct(self::TABLE_NAME);
  }

  public function createOne(Review $review): ?Review
  {
    $lastInsertId = $this->insertRow($review);
    return $lastInsertId ? $this->findOne($lastInsertId) : null;
  }

  public function findOne(int $id, array $filter = []): ?Review
  {
    $data = $this->findRow($id, $filter);
    return $data ? $this->hydrate($data, Review::class) : null;
  }

  public function updateOne(Review $review): ?bool
  {
    return $this->updateRow($review);
  }

  public function deleteOne(int $id): ?bool
  {
    return $this->deleteRow($id);
  }

  public function all(array $filter = []): ReviewCollection
  {
    $data = $this->findAll($filter);
    return $this->hydrateList($data, Review::class, ReviewCollection::class);
  }

  public function pagination(int $page, int $limit, array $filter, string $orderBy = 'ASC'): ReviewCollection
  {
    $data = $this->page($page, $limit, $filter, $orderBy);
    return $this->hydrateList($data, Review::class, ReviewCollection::class);
  }

  public function paginationByField(string $field, mixed $value, int $page, int $limit, array $filter, string $orderBy = 'ASC'): ReviewCollection
  {
    $data = $this->pageByField($field, $value, $page, $limit, $filter, $orderBy);
    return $this->hydrateList($data, Review::class, ReviewCollection::class);
  }

  public function findByUserId(int $userId, array $filter = []): ?Review
  {
    $userData = $this->findRowByField("userId", $userId, $filter);
    return $userData ? $this->hydrate($userData, Review::class) : null;
  }

  public function paginationReviewListByMovie(int $movieId, int $page, int $limit, string $order = 'DESC'): array
  {
    try {
      if ($page < 1)
        $page = 1;
      $offset = ($page - 1) * $limit;

      $query = "SELECT r.id AS reviewId, r.rating, r.comment, r.createdAt, u.id AS userId, u.firstName, u.lastName FROM {$this->table} r JOIN users u ON u.id = r.userId WHERE r.movieId = :movieId ORDER BY r.createdAt {$order} LIMIT {$limit} OFFSET {$offset}";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':movieId', $movieId);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
<?php

namespace ReelRank\Infrastructure\DAO\Persistence;

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
}
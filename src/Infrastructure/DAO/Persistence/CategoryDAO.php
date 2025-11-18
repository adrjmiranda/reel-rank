<?php

namespace ReelRank\Infrastructure\DAO\Persistence;

use ReelRank\Domain\Collection\CategoryCollection;
use ReelRank\Domain\Entities\Category;
use ReelRank\Infrastructure\DAO\DAO;
use ReelRank\Infrastructure\Interfaces\CategoryDAOInterface;

final class CategoryDAO extends DAO implements CategoryDAOInterface
{
  private const string TABLE_NAME = 'categories';

  public function __construct()
  {
    parent::__construct(self::TABLE_NAME);
  }

  public function createOne(Category $category): ?Category
  {
    $lastInsertId = $this->insertRow($category);
    return $lastInsertId ? $this->findOne($lastInsertId) : null;
  }

  public function findOne(int $id, array $filter = []): ?Category
  {
    $data = $this->findRow($id, $filter);
    return $data ? $this->hydrate($data, Category::class) : null;
  }

  public function updateOne(Category $category): ?bool
  {
    return $this->updateRow($category);
  }

  public function deleteOne(int $id): ?bool
  {
    return $this->deleteRow($id);
  }

  public function all(array $filter = []): CategoryCollection
  {
    $data = $this->findAll($filter);
    return $this->hydrateList($data, Category::class, CategoryCollection::class);
  }
}
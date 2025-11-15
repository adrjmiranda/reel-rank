<?php

namespace MovieStar\Infrastructure\Interfaces;

use MovieStar\Domain\Collection\CategoryCollection;
use MovieStar\Domain\Entities\Category;

interface CategoryDAOInterface
{
  public function createOne(Category $category): ?Category;
  public function findOne(int $id, array $filter = []): ?Category;
  public function updateOne(Category $category): ?bool;
  public function deleteOne(int $id): ?bool;
  public function all(array $filter = []): CategoryCollection;
}
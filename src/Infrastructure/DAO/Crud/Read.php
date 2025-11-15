<?php

namespace MovieStar\Infrastructure\DAO\Crud;

use PDO;

trait Read
{
  protected function findRow(int $id, array $filter = []): mixed
  {
    try {
      $filters = empty($filter) ? "*" : implode(", ", $filter);
      $query = "SELECT {$filters} FROM {$this->table} WHERE id = :id LIMIT 1";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(":id", $id, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  protected function findRows(array $ids, array $filter = []): mixed
  {
    try {
      $allIntegers = array_filter($ids, fn($id) => is_int($id) && $id > 0);

      if (count($allIntegers) !== count($ids))
        throw new \RuntimeException("Invalid IDs passed.");


      $filters = empty($filter) ? "*" : implode(", ", $filter);
      $query = "SELECT {$filters} FROM {$this->table} WHERE id  IN (" . implode(", ", $ids) . ")";
      $stmt = $this->pdo->prepare($query);

      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  protected function findRowByField(string $field, mixed $value, array $filter = []): mixed
  {
    try {
      $filters = empty($filter) ? "*" : implode(", ", $filter);
      $query = "SELECT {$filters} FROM {$this->table} WHERE {$field} = :{$field} LIMIT 1";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(":field", $value);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  protected function findAll(array $filter = []): ?array
  {
    try {
      $filters = empty($filter) ? "*" : implode(", ", $filter);

      $query = "SELECT {$filters} FROM {$this->table}";
      $stmt = $this->pdo->prepare($query);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
<?php

namespace ReelRank\Infrastructure\DAO\Crud;

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
      $stmt->bindValue(":{$field}", $value);
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

  protected function findAllByField(string $field, mixed $value, array $filter = []): ?array
  {
    try {
      $filters = empty($filter) ? "*" : implode(", ", $filter);

      $query = "SELECT {$filters} FROM {$this->table} WHERE {$field} = :{$field}";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(":{$field}", $value);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function count(string $field, mixed $value, string $column)
  {
    try {
      $query = "SELECT COUNT({$column}) FROM {$this->table} WHERE {$field} = :{$field}";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(":{$field}", $value);
      $stmt->execute();

      return (int) $stmt->fetchColumn();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function countAll(): int
  {
    try {
      $query = "SELECT COUNT(id) FROM {$this->table}";
      $stmt = $this->pdo->query($query);

      return (int) $stmt->fetchColumn();
    } catch (\Throwable $th) {
      throw $th;
    }
  }


  public function pages(int $limit): int
  {
    if ($limit < 1)
      $limit = 1;
    $total = $this->countAll();

    return (int) floor($total / $limit);
  }

  protected function page(int $page, int $limit, array $filter, string $orderBy = 'ASC'): ?array
  {
    try {
      if ($page < 1)
        $page = 1;
      $offset = $limit * ($page - 1);

      $filters = empty($filter) ? '*' : implode(', ', $filter);

      $query = "SELECT {$filters} FROM {$this->table} ORDER BY createdAt {$orderBy} LIMIT $limit OFFSET $offset";
      $stmt = $this->pdo->query($query);

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  protected function pageByField(string $field, mixed $value, $page, int $limit, array $filter, string $orderBy = 'ASC'): ?array
  {
    try {
      if ($page < 1)
        $page = 1;
      $offset = $limit * ($page - 1);

      $filters = empty($filter) ? '*' : implode(', ', $filter);

      $query = "SELECT {$filters} FROM {$this->table} WHERE {$field} = :{$field} ORDER BY createdAt {$orderBy} LIMIT $limit OFFSET $offset";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(":{$field}", $value);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  protected function searchByField(string $field, mixed $value, $page, int $limit, array $filter, string $orderBy = 'ASC'): ?array
  {
    try {
      if ($page < 1)
        $page = 1;
      $offset = $limit * ($page - 1);

      $filters = empty($filter) ? '*' : implode(', ', $filter);

      $query = "SELECT {$filters} FROM {$this->table} WHERE {$field} LIKE :{$field} ORDER BY createdAt {$orderBy} LIMIT $limit OFFSET $offset";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(":{$field}", "%{$value}%");
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
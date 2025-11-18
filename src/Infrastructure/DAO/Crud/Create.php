<?php

namespace ReelRank\Infrastructure\DAO\Crud;

trait Create
{
  protected function insertRow(object $entity): bool|string
  {
    try {
      $columns = $this->columns($entity);

      $query = "INSERT INTO {$this->table} (" . implode(", ", $columns) . ") VALUES (:" . implode(", :", $columns) . ")";
      $stmt = $this->pdo->prepare($query);
      $this->bindData($stmt, $entity, $columns);

      return $stmt->execute() ? $this->pdo->lastInsertId() : false;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  protected function insertRows(array $data): bool
  {
    try {
      $this->pdo->beginTransaction();

      foreach ($data as $object) {
        $inserted = $this->insertRow($object);
        if (!$inserted)
          throw new \RuntimeException("Failed to insert record with ID {$object->id()->value()}");
      }

      $this->pdo->commit();
      return true;
    } catch (\Throwable $th) {
      $this->pdo->rollBack();
      throw $th;
    }
  }
}
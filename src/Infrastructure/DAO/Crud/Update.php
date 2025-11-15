<?php

namespace MovieStar\Infrastructure\DAO\Crud;

trait Update
{
  protected function updateRow(object $entity): bool
  {
    try {
      $data = $this->data($entity);
      unset($data["createdAt"]);
      $columns = array_keys($data);

      $query = "UPDATE {$this->table} SET " . implode(", ", array_map(fn($column) => "{$column} = :{$column}", $columns)) . " WHERE id = :id";
      $stmt = $this->pdo->prepare($query);
      $this->bindData($stmt, $entity, $columns);

      return $stmt->execute();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  protected function updateRows(array $data): bool
  {
    try {
      $this->pdo->beginTransaction();

      foreach ($data as $object) {
        $updated = $this->updateRow($object);
        if (!$updated)
          throw new \RuntimeException("Failed to update record with ID {$object->id()->value()}");
      }

      $this->pdo->commit();
      return true;
    } catch (\Throwable $th) {
      $this->pdo->rollBack();
      throw $th;
    }
  }
}
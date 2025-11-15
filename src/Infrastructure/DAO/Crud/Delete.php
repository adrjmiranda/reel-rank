<?php

namespace MovieStar\Infrastructure\DAO\Crud;

use PDO;

trait Delete
{
  protected function deleteRow(int $id): bool
  {
    try {
      $query = "DELETE FROM {$this->table} WHERE id = :id";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(":id", $id, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  protected function deleteRows(array $data): bool
  {
    try {
      $this->pdo->beginTransaction();

      foreach ($data as $object) {
        $deleted = $this->deleteRow($object->id()->value());
        if (!$deleted)
          throw new \RuntimeException("Failed to delete record with ID {$object->id()->value()}");
      }

      $this->pdo->commit();
      return true;
    } catch (\Throwable $th) {
      $this->pdo->rollBack();
      throw $th;
    }
  }
}
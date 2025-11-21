<?php

namespace ReelRank\Infrastructure\DAO;

use PDO;
use ReelRank\Infrastructure\Database\Connection;
use ReelRank\Infrastructure\DAO\Data\Handler;
use ReelRank\Infrastructure\DAO\Crud\Create;
use ReelRank\Infrastructure\DAO\Crud\Read;
use ReelRank\Infrastructure\DAO\Crud\Update;
use ReelRank\Infrastructure\DAO\Crud\Delete;

abstract class DAO
{
  // Traits
  use Handler;
  use Create;
  use Read;
  use Update;
  use Delete;

  // Properties
  protected PDO $pdo;
  protected string $table;

  // Construct
  public function __construct(string $table)
  {
    $this->pdo = Connection::get();
    $this->table = $table;
  }

  public function updateData(int $id, array $data): ?bool
  {
    try {
      $query = "UPDATE {$this->table} SET " . implode(', ', array_map(fn($colmun) => "$colmun = :$colmun", array_keys($data))) . " WHERE id = :id";
      $stmt = $this->pdo->prepare($query);
      foreach ($data as $column => $value) {
        $stmt->bindValue(":{$column}", $value);
      }
      $stmt->bindValue(':id', $id);
      return $stmt->execute();
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
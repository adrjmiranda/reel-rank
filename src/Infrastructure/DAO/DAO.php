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
}
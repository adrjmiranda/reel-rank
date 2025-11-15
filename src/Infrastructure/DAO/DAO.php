<?php

namespace MovieStar\Infrastructure\DAO;

use PDO;
use MovieStar\Infrastructure\Database\Connection;
use MovieStar\Infrastructure\DAO\Data\Handler;
use MovieStar\Infrastructure\DAO\Crud\Create;
use MovieStar\Infrastructure\DAO\Crud\Read;
use MovieStar\Infrastructure\DAO\Crud\Update;
use MovieStar\Infrastructure\DAO\Crud\Delete;

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
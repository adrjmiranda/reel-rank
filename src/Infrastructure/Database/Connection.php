<?php

namespace MovieStar\Infrastructure\Database;

use PDO;
use PDOException;

class Connection
{
  private static ?PDO $pdo = null;

  private function __construct()
  {
  }

  public static function get(): PDO
  {
    if (self::$pdo === null) {
      try {
        $config = config("db");

        $host = $config["host"];
        $port = $config["port"];
        $name = $config["name"];
        $user = $config["user"];
        $pass = $config["pass"];

        self::$pdo = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass, [
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
          PDO::ATTR_ERRMODE => isDev() ? PDO::ERRMODE_EXCEPTION : PDO::ERRMODE_SILENT
        ]);
      } catch (PDOException $e) {
        dd($e->getMessage());
      }
    }

    return self::$pdo;
  }
}
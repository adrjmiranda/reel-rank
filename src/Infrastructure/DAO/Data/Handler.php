<?php

namespace ReelRank\Infrastructure\DAO\Data;

use DateTimeImmutable;
use PDO;
use PDOStatement;
use ReelRank\Application\Services\SessionService;
use ReelRank\Application\Services\UserService;
use ReelRank\Domain\ValueObjects\RatingEnum;
use ReflectionClass;
use ReflectionObject;

trait Handler
{
  private function columns(object $entity): array
  {
    $reflection = new ReflectionObject($entity);
    $properties = $reflection->getProperties();

    $names = array_map(fn($p) => $p->getName(), $properties);
    if (($key = array_search("id", $names)) != false)
      unset($names[$key]);

    return $names;
  }

  private function data(object $entity): array
  {
    $reflection = new ReflectionObject($entity);
    $properties = $reflection->getProperties();
    $array = [];

    foreach ($properties as $property) {
      $property->setAccessible(true);
      $name = $property->getName();
      $value = $entity->$name()?->value();
      $array[$property->getName()] = $value;
    }


    return $array;
  }

  private function bindData(PDOStatement &$stmt, object $entity, array $columns): void
  {
    foreach ($columns as $name) {
      $value = $entity->$name()?->value();
      if ($value instanceof DateTimeImmutable)
        $value = $value->format('Y-m-d H:i:s');

      $stmt->bindValue(":{$name}", $value);
    }
  }

  private function properties(string $class): array
  {
    $reflection = new ReflectionClass($class);
    $properties = $reflection->getProperties();
    $array = [];

    foreach ($properties as $property) {
      $property->setAccessible(true);
      $array[] = $property->getName();
    }

    return $array;
  }

  protected function hydrate(array $row, string $class): object
  {
    $reflection = new ReflectionClass($class);
    $properties = $this->properties($class);

    $instance = $reflection->newInstanceArgs(
      array_map(function ($property) use ($row) {
        $typeName = ucfirst($property);
        $typeNamespace = "ReelRank\\Domain\\ValueObjects\\{$typeName}";

        $value = match ($property) {
          "createdAt" => isset($row['createdAt']) ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row[$property]) : null,
          "updatedAt" => isset($row['updatedAt']) ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row[$property]) : null,
          'rating' => RatingEnum::from($row['rating']),
          default => $row[$property] ?? null,
        };

        return $value ? new $typeNamespace($value) : null;
      }, $properties)
    );

    return $instance;
  }

  protected function hydrateList(array $data, string $class, string $collectionClass): object
  {
    $list = [];
    foreach ($data as $entity) {
      $list[] = $this->hydrate($entity, $class);
    }

    return new $collectionClass($list);
  }
}
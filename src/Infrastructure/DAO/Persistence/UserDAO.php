<?php

namespace ReelRank\Infrastructure\DAO\Persistence;

use ReelRank\Domain\Collection\UserCollection;
use ReelRank\Domain\Entities\User;
use ReelRank\Infrastructure\DAO\DAO;
use ReelRank\Infrastructure\Interfaces\UserDAOInterface;

final class UserDAO extends DAO implements UserDAOInterface
{
  private const string TABLE_NAME = 'users';

  public function __construct()
  {
    parent::__construct(self::TABLE_NAME);
  }

  public function createOne(User $user): ?User
  {
    $lastInsertId = $this->insertRow($user);
    return $lastInsertId ? $this->findOne($lastInsertId) : null;
  }

  public function findOne(int $id, array $filter = []): ?User
  {
    $data = $this->findRow($id, $filter);
    return $data ? $this->hydrate($data, User::class) : null;
  }

  public function updateOne(User $user): ?bool
  {
    return $this->updateRow($user);
  }

  public function deleteOne(int $id): bool
  {
    return $this->deleteRow($id);
  }

  public function findByEmail(string $email, array $filter = []): ?User
  {
    $userData = $this->findRowByField("email", $email, $filter);
    return $userData ? $this->hydrate($userData, User::class) : null;
  }

  public function all(array $filter = []): UserCollection
  {
    $data = $this->findAll($filter);
    return $this->hydrateList($data, User::class, UserCollection::class);
  }

  public function pagination(int $page, int $limit, array $filter, string $orderBy = 'ASC'): UserCollection
  {
    $data = $this->page($page, $limit, $filter, $orderBy);
    return $this->hydrateList($data, User::class, UserCollection::class);
  }
}
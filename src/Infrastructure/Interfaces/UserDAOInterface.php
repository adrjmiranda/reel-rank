<?php

namespace ReelRank\Infrastructure\Interfaces;

use ReelRank\Domain\Collection\UserCollection;
use ReelRank\Domain\Entities\User;

interface UserDAOInterface
{
  public function createOne(User $user): ?User;
  public function findOne(int $id): ?User;
  public function updateOne(User $user): ?bool;
  public function deleteOne(int $id): ?bool;
  public function findByEmail(string $email): ?User;
  public function all(array $filter = []): UserCollection;
}
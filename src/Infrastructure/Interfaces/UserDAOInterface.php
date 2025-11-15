<?php

namespace MovieStar\Infrastructure\Interfaces;

use MovieStar\Domain\Collection\UserCollection;
use MovieStar\Domain\Entities\User;

interface UserDAOInterface
{
  public function createOne(User $user): ?User;
  public function findOne(int $id): ?User;
  public function updateOne(User $user): ?bool;
  public function deleteOne(int $id): ?bool;
  public function findByEmail(string $email): ?User;
  public function all(array $filter = []): UserCollection;
}
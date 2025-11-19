<?php

namespace ReelRank\Domain\Entities;

use ReelRank\Domain\ValueObjects\FirstName;
use ReelRank\Domain\ValueObjects\LastName;
use ReelRank\Domain\ValueObjects\Email;
use ReelRank\Domain\ValueObjects\Password;
use ReelRank\Domain\ValueObjects\Id;
use ReelRank\Domain\ValueObjects\Image;
use ReelRank\Domain\ValueObjects\Bio;
use ReelRank\Domain\ValueObjects\CreatedAt;
use ReelRank\Domain\ValueObjects\UpdatedAt;

class User extends Entity
{
  public function __construct(
    private FirstName $firstName,
    private LastName $lastName,
    private Email $email,
    private Password $password,
    private ?Id $id = null,
    private ?Image $image = null,
    private ?Bio $bio = null,
    private ?CreatedAt $createdAt = null,
    private ?UpdatedAt $updatedAt = null
  ) {
    parent::__construct($id, $createdAt, $updatedAt);
  }

  public function firstName(): FirstName
  {
    return $this->firstName;
  }

  public function lastName(): LastName
  {
    return $this->lastName;
  }

  public function email(): Email
  {
    return $this->email;
  }

  public function password(): Password
  {
    return $this->password;
  }

  public function image(): ?Image
  {
    return $this->image;
  }

  public function bio(): ?Bio
  {
    return $this->bio;
  }
}
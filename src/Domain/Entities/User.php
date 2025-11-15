<?php

namespace MovieStar\Domain\Entities;

use MovieStar\Domain\ValueObjects\FirstName;
use MovieStar\Domain\ValueObjects\LastName;
use MovieStar\Domain\ValueObjects\Email;
use MovieStar\Domain\ValueObjects\PasswordHash;
use MovieStar\Domain\ValueObjects\Id;
use MovieStar\Domain\ValueObjects\Image;
use MovieStar\Domain\ValueObjects\Bio;
use MovieStar\Domain\ValueObjects\CreatedAt;
use MovieStar\Domain\ValueObjects\UpdatedAt;

class User extends Entity
{
  public function __construct(
    private FirstName $firstName,
    private LastName $lastName,
    private Email $email,
    private PasswordHash $passwordHash,
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

  public function passwordHash(): PasswordHash
  {
    return $this->passwordHash;
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
<?php

use ReelRank\Infrastructure\DAO\Persistence\CategoryDAO;
use ReelRank\Infrastructure\DAO\Persistence\MovieDAO;
use ReelRank\Infrastructure\DAO\Persistence\ReviewDAO;
use ReelRank\Infrastructure\DAO\Persistence\UserDAO;
use ReelRank\Infrastructure\Data\PersistentInput;
use ReelRank\Infrastructure\Data\Sanitize;
use ReelRank\Infrastructure\Message\Flash;
use ReelRank\Infrastructure\Template\Engine;
use ReelRank\Infrastructure\Validation\Validation;

return [
  UserDAO::class => fn(): UserDAO => new UserDAO(),
  MovieDAO::class => fn(): MovieDAO => new MovieDAO(),
  CategoryDAO::class => fn(): CategoryDAO => new CategoryDAO(),
  ReviewDAO::class => fn(): ReviewDAO => new ReviewDAO(),
  Engine::class => fn(): Engine => new Engine(),
  Validation::class => fn(): Validation => new Validation(),
  Sanitize::class => fn(): Sanitize => new Sanitize(),
  Flash::class => fn(): Flash => new Flash(),
  PersistentInput::class => fn(): PersistentInput => new PersistentInput(),
];

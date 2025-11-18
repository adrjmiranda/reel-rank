<?php

use ReelRank\Infrastructure\DAO\Persistence\CategoryDAO;
use ReelRank\Infrastructure\DAO\Persistence\MovieDAO;
use ReelRank\Infrastructure\DAO\Persistence\ReviewDAO;
use ReelRank\Infrastructure\DAO\Persistence\UserDAO;
use ReelRank\Infrastructure\Template\Engine;

return [
  UserDAO::class => fn(): UserDAO => new UserDAO(),
  MovieDAO::class => fn(): MovieDAO => new MovieDAO(),
  CategoryDAO::class => fn(): CategoryDAO => new CategoryDAO(),
  ReviewDAO::class => fn(): ReviewDAO => new ReviewDAO(),
  Engine::class => fn(): Engine => new Engine(),
];

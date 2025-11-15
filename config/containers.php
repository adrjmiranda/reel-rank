<?php

use MovieStar\Infrastructure\DAO\Persistence\CategoryDAO;
use MovieStar\Infrastructure\DAO\Persistence\MovieDAO;
use MovieStar\Infrastructure\DAO\Persistence\ReviewDAO;
use MovieStar\Infrastructure\DAO\Persistence\UserDAO;
use MovieStar\Infrastructure\Template\Engine;

return [
  UserDAO::class => fn(): UserDAO => new UserDAO(),
  MovieDAO::class => fn(): MovieDAO => new MovieDAO(),
  CategoryDAO::class => fn(): CategoryDAO => new CategoryDAO(),
  ReviewDAO::class => fn(): ReviewDAO => new ReviewDAO(),
  Engine::class => fn(): Engine => new Engine(),
];

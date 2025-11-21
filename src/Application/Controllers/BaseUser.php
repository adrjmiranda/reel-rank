<?php

namespace ReelRank\Application\Controllers;

use ReelRank\Application\Services\ImageService;
use ReelRank\Application\Services\SessionService;
use ReelRank\Application\Services\UserService;
use ReelRank\Infrastructure\DAO\Persistence\CategoryDAO;
use ReelRank\Infrastructure\DAO\Persistence\MovieDAO;
use ReelRank\Infrastructure\DAO\Persistence\ReviewDAO;
use ReelRank\Infrastructure\DAO\Persistence\UserDAO;

use ReelRank\Infrastructure\Data\PersistentInput;
use ReelRank\Infrastructure\Data\Sanitize;
use ReelRank\Infrastructure\Message\Flash;
use ReelRank\Infrastructure\Template\Engine;
use ReelRank\Infrastructure\Validation\Validation;

abstract class BaseUser extends Controller
{
  protected UserService $userService;
  protected ImageService $imageService;
  protected UserDAO $userDAO;
  protected MovieDAO $movieDAO;
  protected CategoryDAO $categoryDAO;
  protected ReviewDAO $reviewDAO;

  public function __construct(
    Engine $engine,
    Validation $validation,
    Sanitize $sanitize,
    SessionService $sessionService,
    Flash $flash,
    PersistentInput $persistentInput,
    UserService $userService,
    ImageService $imageService,
    UserDAO $userDAO,
    MovieDAO $movieDAO,
    CategoryDAO $categoryDAO,
    ReviewDAO $reviewDAO,
  ) {
    $this->userService = $userService;
    $this->imageService = $imageService;
    $this->userDAO = $userDAO;
    $this->movieDAO = $movieDAO;
    $this->categoryDAO = $categoryDAO;
    $this->reviewDAO = $reviewDAO;
    parent::__construct($engine, $validation, $sanitize, $flash, $persistentInput, $sessionService);
  }
}
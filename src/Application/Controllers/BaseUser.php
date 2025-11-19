<?php

namespace ReelRank\Application\Controllers;

use ReelRank\Application\Services\UserService;
use ReelRank\Infrastructure\DAO\Persistence\UserDAO;

use ReelRank\Infrastructure\Data\PersistentInput;
use ReelRank\Infrastructure\Data\Sanitize;
use ReelRank\Infrastructure\Message\Flash;
use ReelRank\Infrastructure\Template\Engine;
use ReelRank\Infrastructure\Validation\Validation;
use Twig\Environment;

abstract class BaseUser extends Controller
{
  protected UserDAO $userDAO;
  protected UserService $userService;

  public function __construct(Engine $engine, Validation $validation, Sanitize $sanitize, Flash $flash, PersistentInput $persistentInput, UserDAO $userDAO, UserService $userService)
  {
    $this->userDAO = $userDAO;
    $this->userService = $userService;
    parent::__construct($engine, $validation, $sanitize, $flash, $persistentInput);
  }
}
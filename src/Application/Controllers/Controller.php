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
use Twig\Environment;


abstract class Controller
{
  private Environment $twig;


  public function __construct(
    protected Engine $engine,
    protected Validation $validation,
    protected Sanitize $sanitize,
    protected Flash $flash,
    protected PersistentInput $persistentInput,
    protected SessionService $sessionService,
    protected UserService $userService,
    protected ImageService $imageService,
    protected UserDAO $userDAO,
    protected MovieDAO $movieDAO,
    protected CategoryDAO $categoryDAO,
    protected ReviewDAO $reviewDAO
  ) {
    $this->twig = $engine::get();
  }

  protected function view(string $template, array $data = []): string
  {
    $templateConfig = config("template");
    $data = array_merge($templateConfig, $data);
    return $this->twig->render(str_replace(".", "/", $template) . ".html", $data);
  }
}
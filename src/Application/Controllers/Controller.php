<?php

namespace ReelRank\Application\Controllers;

use ReelRank\Application\Services\SessionService;
use ReelRank\Infrastructure\Data\PersistentInput;
use ReelRank\Infrastructure\Data\Sanitize;
use ReelRank\Infrastructure\Message\Flash;
use ReelRank\Infrastructure\Template\Engine;
use ReelRank\Infrastructure\Validation\Validation;
use Twig\Environment;


abstract class Controller
{
  private Environment $twig;
  protected Validation $validation;
  protected Sanitize $sanitize;
  protected Flash $flash;
  protected PersistentInput $persistentInput;
  protected SessionService $sessionService;

  public function __construct(
    Engine $engine,
    Validation $validation,
    Sanitize $sanitize,
    Flash $flash,
    PersistentInput $persistentInput,
    SessionService $sessionService
  ) {
    $this->twig = $engine::get();
    $this->validation = $validation;
    $this->sanitize = $sanitize;
    $this->flash = $flash;
    $this->persistentInput = $persistentInput;
    $this->sessionService = $sessionService;
  }

  protected function view(string $template, array $data = []): string
  {
    $templateConfig = config("template");
    $data = array_merge($templateConfig, $data);
    return $this->twig->render(str_replace(".", "/", $template) . ".html", $data);
  }


}
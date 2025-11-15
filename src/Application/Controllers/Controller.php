<?php

namespace MovieStar\Application\Controllers;

use MovieStar\Infrastructure\Template\Engine;
use Twig\Environment;

abstract class Controller
{
  private Environment $twig;

  public function __construct(Engine $engine)
  {
    $this->twig = $engine::get();
  }

  protected function view(string $template, array $data = []): string
  {
    $templateConfig = config("template");
    $data = array_merge($templateConfig, $data);
    return $this->twig->render(str_replace(".", "/", $template) . ".html", $data);
  }
}
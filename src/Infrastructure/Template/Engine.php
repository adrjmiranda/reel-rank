<?php

namespace MovieStar\Infrastructure\Template;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

final class Engine
{
  private static ?Environment $twig = null;

  public function __construct()
  {
  }

  public static function get(): Environment
  {
    if (self::$twig === null) {
      self::$twig = new Environment(
        new FilesystemLoader(directory("resources.views")),
        config("twig")
      );

      $functions = config("twig-func");
      foreach ($functions as $name => $handler) {
        self::$twig->addFunction(new TwigFunction($name, $handler));
      }
    }

    return self::$twig;
  }
}
<?php

namespace MovieStar\Domain\Exception;

use Exception;

class InvalidNameException extends Exception
{
  public function __construct(string $value, int $code = 500)
  {
    $message = "Invalid name: {$value}";
    parent::__construct($message, $code);
  }
}
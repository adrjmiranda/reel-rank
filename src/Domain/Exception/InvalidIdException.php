<?php

namespace MovieStar\Domain\Exception;

use Exception;

class InvalidIdException extends Exception
{
  public function __construct(string $value, int $code = 500)
  {
    $message = "Invalid id: {$value}";
    parent::__construct($message, $code);
  }
}
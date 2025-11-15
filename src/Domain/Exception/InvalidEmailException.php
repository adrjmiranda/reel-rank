<?php


namespace MovieStar\Domain\Exception;

use Exception;

class InvalidEmailException extends Exception
{
  public function __construct(string $value, int $code = 500)
  {
    $message = "Invalid email: {$value}";
    parent::__construct($message, $code);
  }
}
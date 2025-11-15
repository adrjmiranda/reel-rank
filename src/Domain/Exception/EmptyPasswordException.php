<?php

namespace MovieStar\Domain\Exception;

use Exception;

class EmptyPasswordException extends Exception
{
  public function __construct(int $code = 500)
  {
    $message = "Empty password.";
    parent::__construct($message, $code);
  }
}
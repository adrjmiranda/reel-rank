<?php

namespace MovieStar\Domain\Exception;

use Exception;

class EmptyNameException extends Exception
{
  public function __construct(int $code = 500)
  {
    $message = "Empty name.";
    parent::__construct($message, $code);
  }
}
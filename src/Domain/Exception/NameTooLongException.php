<?php

namespace MovieStar\Domain\Exception;

use Exception;

class NameTooLongException extends Exception
{
  public function __construct(int $maxLength, int $code = 500)
  {
    $message = "The provided name exceeds the maximum length of {$maxLength} characters.";
    parent::__construct($message, $code);
  }
}
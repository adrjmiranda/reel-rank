<?php

namespace ReelRank\Domain\Exception;

use Exception;

class InvalidDurationException extends Exception
{
  public function __construct(int $value, int $code = 500)
  {
    $message = "Invalid duration: $value";
    parent::__construct($message, $code);
  }
}
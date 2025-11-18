<?php

namespace ReelRank\Domain\Exception;

use Exception;

class DescriptionTooLongException extends Exception
{
  public function __construct(int $maxLength, int $code = 500)
  {
    $message = "The provided bio exceeds the maximum length of {$maxLength} characters.";
    parent::__construct($message, $code);
  }
}
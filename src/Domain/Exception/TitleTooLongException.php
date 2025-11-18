<?php

namespace ReelRank\Domain\Exception;

use Exception;

class TitleTooLongException extends Exception
{
  public function __construct(int $maxLength, int $code = 500)
  {
    $message = "The provided title exceeds the maximum length of {$maxLength} characters.";
    parent::__construct($message, $code);
  }
}
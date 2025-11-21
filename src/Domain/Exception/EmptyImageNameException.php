<?php

namespace ReelRank\Domain\Exception;

use Exception;

class EmptyImageNameException extends Exception
{
  public function __construct(int $code = 500)
  {
    $message = "Empty image name.";
    parent::__construct($message, $code);
  }
}
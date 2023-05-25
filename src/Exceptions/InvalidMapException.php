<?php

namespace PathFind\Exceptions;

use Exception;
use Throwable;

class InvalidMapException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return 'The map provided was invalid with the following error: '.$this->message;
    }
}

<?php

namespace PathFind\Exceptions;

use Exception;
use Throwable;

class InvalidPathException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return 'Could not find a valid path';
    }
}

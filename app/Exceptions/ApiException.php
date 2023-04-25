<?php

namespace App\Exceptions;

class ApiException extends \Exception
{
    public function __construct($message = null, $code = 400, \Throwable $previous = null)
    {
        $message = (app()->environment() !== 'local' || !$message) ?
            "Sorry we couldn't handle your request, Please contact support" :
            $message;

        parent::__construct($message, $code, $previous);
    }
}

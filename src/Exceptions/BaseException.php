<?php

namespace Nurigo\Solapi\Exceptions;

use Exception;

class BaseException extends Exception
{

    /**
     * @var string
     */
    public $errorCode;

    public function __construct($message = "", $errorCode = "")
    {
        parent::__construct($message);
        $this->errorCode = $errorCode;
    }
}
<?php

namespace Nurigo\Solapi\Exceptions;

use Exception;

class UnknownException extends Exception
{

    /**
     * @var mixed
     */
    public $response;

    public function __construct($message = "", $errorResponse = null)
    {
        parent::__construct($message);
        $this->response = $errorResponse;
    }

    /**
     * @return mixed|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}
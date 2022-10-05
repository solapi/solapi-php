<?php

namespace Nurigo\Solapi\Models\Response;

use JsonSerializable;

class ErrorResponse implements JsonSerializable
{
    /**
     * @var string
     */
    public $errorCode;

    /**
     * @var string
     */
    public $errorMessage;

    /**
     * @param $value mixed
     */
    public function __construct($value)
    {
        $this->errorCode = $value->errorCode;
        $this->errorMessage = $value->errorMessage;
    }

    public function jsonSerialize(): array
    {
        return [
            "errorCode" => $this->errorCode,
            "errorMessage" => $this->errorMessage
        ];
    }
}
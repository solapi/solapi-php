<?php

namespace Nurigo\Solapi\Exceptions;

class BmsValidationException extends BaseException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 'BMS_VALIDATION_ERROR');
    }
}

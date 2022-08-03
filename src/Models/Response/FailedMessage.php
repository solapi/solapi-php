<?php

namespace Nurigo\Solapi\Models\Response;

class FailedMessage
{
    /**
     * @var string
     */
    public $to;

    /**
     * @var string
     */
    public $from;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $statusMessage;

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $messageId;

    /**
     * @var string
     */
    public $statusCode;

    /**
     * @var string
     */
    public $accountId;
}
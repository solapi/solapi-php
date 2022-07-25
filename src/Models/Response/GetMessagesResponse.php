<?php

namespace Nurigo\Solapi\Models\Response;

use Nurigo\Solapi\Models\Message;

class GetMessagesResponse
{
    /**
     * @var int
     */
    public $limit;

    /**
     * @var Message[]
     */
    public $messageList;

    /**
     * @var string
     */
    public $startKey;

    /**
     * @var string
     */
    public $nextKey;


    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->limit = $value->limit;
        $this->messageList = $value->messageList;
        $this->startKey = $value->startKey;
        $this->nextKey = $value->nextKey;
    }
}
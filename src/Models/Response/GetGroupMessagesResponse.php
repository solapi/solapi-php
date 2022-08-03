<?php

namespace Nurigo\Solapi\Models\Response;

use Nurigo\Solapi\Models\BaseMessage;

class GetGroupMessagesResponse
{
    /**
     * @var string
     */
    public $startKey;

    /**
     * @var string
     */
    public $nextKey;

    /**
     * @var int
     */
    public $limit;

    /**
     * @var BaseMessage[]
     */
    public $messageList;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->limit = $value->limit ?? null;
        $this->messageList = $value->messageList ?? null;
        $this->startKey = $value->startKey ?? null;
        $this->nextKey = $value->nextKey ?? null;
    }
}
<?php

namespace Nurigo\Solapi\Exceptions;

use Exception;
use Nurigo\Solapi\Models\Response\FailedMessage;

class MessageNotReceivedException extends Exception
{
    /**
     * @var FailedMessage[]
     */
    public $failedMessageList;

    /**
     * @param FailedMessage[] $failedMessageList
     */
    public function __construct($failedMessageList)
    {
        $this->failedMessageList = $failedMessageList;
        parent::__construct("메시지 접수에 실패했습니다.");
    }

    /**
     * @return FailedMessage[]
     */
    public function getFailedMessageList(): array
    {
        return $this->failedMessageList;
    }
}
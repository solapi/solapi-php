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
        parent::__construct("메시지 접수에 실패했습니다.");
        $this->failedMessageList = $failedMessageList;
    }

    /**
     * @return FailedMessage[]
     */
    public function getFailedMessageList(): array
    {
        return $this->failedMessageList;
    }
}
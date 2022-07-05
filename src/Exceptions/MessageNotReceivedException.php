<?php

namespace Nurigo\Solapi\Exceptions;

use Exception;

class MessageNotReceivedException extends Exception
{
    /**
     * @var array
     */
    public $failedMessageList;

    /**
     * @param array $failedMessageList
     */
    public function __construct(array $failedMessageList)
    {
        $this->failedMessageList = $failedMessageList;
        parent::__construct("메시지 접수에 실패했습니다.");
    }

    /**
     * @return array
     */
    public function getFailedMessageList(): array
    {
        return $this->failedMessageList;
    }
}
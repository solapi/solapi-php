<?php

namespace Nurigo\Solapi\Models\Response;

use JsonSerializable;

class SendResponse implements JsonSerializable
{
    /**
     * @var GroupMessageResponse
     */
    public $groupInfo;

    /**
     * @var FailedMessage[]
     */
    public $failedMessageList;

    /**
     * @param $value mixed
     */
    public function __construct($value)
    {
        $this->groupInfo = $value->groupInfo;
        $this->failedMessageList = $value->failedMessageList;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "groupInfo" => $this->groupInfo,
            "failedMessageList" => $this->failedMessageList
        ];
    }
}
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
     * @var array
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

    public function jsonSerialize(): array
    {
        return [
            "groupInfo" => $this->groupInfo,
            "failedMessageList" => $this->failedMessageList
        ];
    }
}
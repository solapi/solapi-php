<?php

namespace Nurigo\Solapi\Models\Request;

class GetGroupMessagesRequest
{
    /**
     * @var string
     */
    public $startKey;

    /**
     * @var int
     */
    public $limit;

    /**
     * @return string
     */
    public function getStartKey(): string
    {
        return $this->startKey;
    }

    /**
     * @param string $startKey
     * @return GetGroupMessagesRequest
     */
    public function setStartKey(string $startKey): GetGroupMessagesRequest
    {
        $this->startKey = $startKey;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return GetGroupMessagesRequest
     */
    public function setLimit(int $limit): GetGroupMessagesRequest
    {
        $this->limit = $limit;
        return $this;
    }
}
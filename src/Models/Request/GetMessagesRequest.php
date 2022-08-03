<?php

namespace Nurigo\Solapi\Models\Request;

class GetMessagesRequest
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
     * @var string
     */
    public $messageId;

    /**
     * @var string[]
     */
    public $messageIds;

    /**
     * @var string
     */
    public $groupId;

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
    public $statusCode;

    /**
     * @var string CREATED|UPDATED
     */
    public $dateType = 'CREATED';

    /**
     * @var string
     */
    public $startDate;

    /**
     * @var string
     */
    public $endDate;

    /**
     * @return string
     */
    public function getStartKey(): string
    {
        return $this->startKey;
    }

    /**
     * @param string $startKey
     * @return GetMessagesRequest
     */
    public function setStartKey(string $startKey): GetMessagesRequest
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
     * @return GetMessagesRequest
     */
    public function setLimit(int $limit): GetMessagesRequest
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @param string $messageId
     * @return GetMessagesRequest
     */
    public function setMessageId(string $messageId): GetMessagesRequest
    {
        $this->messageId = $messageId;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getMessageIds(): array
    {
        return $this->messageIds;
    }

    /**
     * @param string[] $messageIds
     * @return GetMessagesRequest
     */
    public function setMessageIds(array $messageIds): GetMessagesRequest
    {
        $this->messageIds = $messageIds;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupId(): string
    {
        return $this->groupId;
    }

    /**
     * @param string $groupId
     * @return GetMessagesRequest
     */
    public function setGroupId(string $groupId): GetMessagesRequest
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     * @return GetMessagesRequest
     */
    public function setTo(string $to): GetMessagesRequest
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @return GetMessagesRequest
     */
    public function setFrom(string $from): GetMessagesRequest
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return GetMessagesRequest
     */
    public function setType(string $type): GetMessagesRequest
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusCode
     * @return GetMessagesRequest
     */
    public function setStatusCode(string $statusCode): GetMessagesRequest
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateType(): string
    {
        return $this->dateType;
    }

    /**
     * @param string $dateType
     * @return GetMessagesRequest
     */
    public function setDateType(string $dateType): GetMessagesRequest
    {
        $this->dateType = $dateType;
        return $this;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     * @return GetMessagesRequest
     */
    public function setStartDate(string $startDate): GetMessagesRequest
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     * @return GetMessagesRequest
     */
    public function setEndDate(string $endDate): GetMessagesRequest
    {
        $this->endDate = $endDate;
        return $this;
    }
}
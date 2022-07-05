<?php

namespace Nurigo\Solapi\Models;

use Nurigo\Solapi\Models\kakao\KakaoOption;

class Message
{
    public $to;
    public $from;
    public $text;
    public $groupId;
    public $messageId;
    public $imageId;
    public $type;
    public $subject;
    public $autoTypeDetect = true;
    public $country = "82";

    public $kakaoOptions;

    public $logs = array();

    public $dateCreated;
    public $dateUpdated;

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     * @return Message
     */
    public function setTo(string $to): Message
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
     * @return Message
     */
    public function setFrom(string $from): Message
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Message
     */
    public function setText(string $text): Message
    {
        $this->text = $text;
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
     * @return Message
     */
    public function setGroupId(string $groupId): Message
    {
        $this->groupId = $groupId;
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
     * @return Message
     */
    public function setMessageId(string $messageId): Message
    {
        $this->messageId = $messageId;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageId(): string
    {
        return $this->imageId;
    }

    /**
     * @param string $imageId
     * @return Message
     */
    public function setImageId(string $imageId): Message
    {
        $this->imageId = $imageId;
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
     * @return Message
     */
    public function setType(string $type): Message
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return Message
     */
    public function setSubject(string $subject): Message
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoTypeDetect(): bool
    {
        return $this->autoTypeDetect;
    }

    /**
     * @param bool $autoTypeDetect
     * @return Message
     */
    public function setAutoTypeDetect(bool $autoTypeDetect): Message
    {
        $this->autoTypeDetect = $autoTypeDetect;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Message
     */
    public function setCountry(string $country): Message
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return KakaoOption
     */
    public function getKakaoOptions(): KakaoOption
    {
        return $this->kakaoOptions;
    }

    /**
     * @param KakaoOption $kakaoOptions
     * @return Message
     */
    public function setKakaoOptions(KakaoOption $kakaoOptions): Message
    {
        $this->kakaoOptions = $kakaoOptions;
        return $this;
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }

    /**
     * @param array $logs
     * @return Message
     */
    public function setLogs(array $logs): Message
    {
        $this->logs = $logs;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreated(): string
    {
        return $this->dateCreated;
    }

    /**
     * @param string $dateCreated
     * @return Message
     */
    public function setDateCreated(string $dateCreated): Message
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateUpdated(): string
    {
        return $this->dateUpdated;
    }

    /**
     * @param string $dateUpdated
     * @return Message
     */
    public function setDateUpdated(string $dateUpdated): Message
    {
        $this->dateUpdated = $dateUpdated;
        return $this;
    }
}
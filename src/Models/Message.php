<?php

namespace Nurigo\Solapi\Models;

use Nurigo\Solapi\Models\Kakao\KakaoOption;

class Message extends BaseMessage
{
    /**
     * @var string 수신번호
     */
    public $to;

    /**
     * @var string 발신번호
     */
    public $from;

    /**
     * @var string 메시지 내용(SMS, LMS, MMS, CTA, CTI 전용)
     */
    public $text;

    /**
     * @var string 스토리지 내 이미지 ID
     */
    public $imageId;

    /**
     * @var string 문자 제목(LMS, MMS 전용 옵션)
     */
    public $subject;

    /**
     * @var string 국가번호
     */
    public $country = "82";

    /**
     * @var KakaoOption
     */
    public $kakaoOptions;

    /**
     * @var string
     */
    public $messageId;

    /**
     * @var string
     */
    public $groupId;

    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $autoTypeDetect;

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
}
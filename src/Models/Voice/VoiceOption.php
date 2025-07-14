<?php

namespace Nurigo\Solapi\Models\Voice;

class VoiceOption {

    /**
     * @var string
     */
    public $voiceType;

    /**
     * @var string
     */
    public $headerMessage;

    /**
     * @var string
     */
    public $tailMessage;

    /**
     * @var int
     */
    public $replyRange;

    /**
     * @var string
     */
    public $counselorNumber;

    /**
     * @return string
     */
    public function getVoiceType(): string
    {
        return $this->voiceType;
    }

    /**
     * @param string $voiceType
     * @return VoiceOption
     */
    public function setVoiceType(string $voiceType): VoiceOption
    {
        $this->voiceType = $voiceType;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeaderMessage(): string
    {
        return $this->headerMessage;
    }

    /**
     * @param string $headerMessage
     * @return VoiceOption
     */
    public function setHeaderMessage(string $headerMessage): VoiceOption
    {
        $this->headerMessage = $headerMessage;
        return $this;
    }

    /**
     * @return string
     */
    public function getTailMessage(): string
    {
        return $this->tailMessage;
    }

    /**
     * @param string $tailMessage
     * @return VoiceOption
     */
    public function setTailMessage(string $tailMessage): VoiceOption
    {
        $this->tailMessage = $tailMessage;
        return $this;
    }

    /**
     * @return int
     */
    public function getReplyRange(): int
    {
        return $this->replyRange;
    }

    /**
     * @param int $replyRange
     * @return VoiceOption
     */
    public function setReplyRange(int $replyRange): VoiceOption
    {
        $this->replyRange = $replyRange;
        return $this;
    }

    /**
     * @return string
     */
    public function getCounselorNumber(): string
    {
        return $this->counselorNumber;
    }

    /**
     * @param string $counselorNumber
     * @return VoiceOption
     */
    public function setCounselorNumber(string $counselorNumber): VoiceOption
    {
        $this->counselorNumber = $counselorNumber;
        return $this;
    }
}

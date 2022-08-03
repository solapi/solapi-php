<?php

namespace Nurigo\Solapi\Models\Request;

use DateTime;
use Nurigo\Solapi\Models\Message;

class SendRequest
{
    /**
     * @var Message[] 메시지를 발송할 객체
     */
    public $messages;

    /**
     * @var string 예약일시
     */
    public $scheduledDate;

    /**
     * @var DefaultAgent SDK 정보를 담은 객체
     */
    public $agent;

    /**
     * @var bool 중복 수신번호 허용여부, 기본 값은 비허용
     */
    public $allowDuplicates = false;

    /**
     * @param Message[] $messages
     * @param DateTime|null $scheduledDate
     * @param bool $allowDuplicates
     */
    public function __construct($messages, $scheduledDate = null, $allowDuplicates = false)
    {
        $this->messages = $messages;
        if ($scheduledDate != null) {
            $this->scheduledDate = $scheduledDate->format('c');
        } else {
            unset($this->scheduledDate);
        }
        $this->agent = new DefaultAgent();
        $this->allowDuplicates = $allowDuplicates;
    }
}
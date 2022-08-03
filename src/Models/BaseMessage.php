<?php

namespace Nurigo\Solapi\Models;

use Nurigo\Solapi\Models\Kakao\BaseKakaoOption;

class BaseMessage
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
     * @var BaseKakaoOption
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
}
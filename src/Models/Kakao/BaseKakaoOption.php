<?php

namespace Nurigo\Solapi\Models\Kakao;

class BaseKakaoOption
{
    /**
     * @var string 카카오 채널 ID
     */
    public $pfId;

    /**
     * @var string 카카오 알림톡 템플릿 ID
     */
    public $templateId;

    /**
     * @var bool 대체 발송 비활성화 옵션
     * true일 경우에만 대체 발송이 비활성화 됩니다.
     */
    public $disableSms = false;

    /**
     * @var bool
     */
    public $adFlag = false;

    /**
     * @var array 메시지 버튼 목록
     */
    public $buttons;

    /**
     * @var string 이미지 아이디(스토리지에 업로드 된 이미지 ID)
     */
    public $imageId;
}
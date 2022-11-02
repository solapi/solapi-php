<?php

namespace Nurigo\Solapi\Models\Kakao;

use stdClass;

class KakaoOption extends BaseKakaoOption
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
     * @var stdClass|null 치환문구 처리변수
     */
    public $variables;

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

    /**
     * @return string
     */
    public function getImageId(): string
    {
        return $this->imageId;
    }

    /**
     * @param string $imageId
     */
    public function setImageId(string $imageId)
    {
        $this->imageId = $imageId;
    }

    /**
     * @return string
     */
    public function getPfId(): string
    {
        return $this->pfId;
    }

    /**
     * @param string $pfId
     * @return KakaoOption
     */
    public function setPfId(string $pfId): KakaoOption
    {
        $this->pfId = $pfId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateId(): string
    {
        return $this->templateId;
    }

    /**
     * @param string $templateId
     * @return KakaoOption
     */
    public function setTemplateId(string $templateId): KakaoOption
    {
        $this->templateId = $templateId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param mixed $variables
     * @return KakaoOption
     */
    public function setVariables($variables): KakaoOption
    {
        $this->variables = $variables;
        return $this;
    }

    /**
     * @return bool
     */
    public function getDisableSms(): bool
    {
        return $this->disableSms;
    }

    /**
     * @param bool $disableSms
     * @return KakaoOption
     */
    public function setDisableSms(bool $disableSms): KakaoOption
    {
        $this->disableSms = $disableSms;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdFlag(): bool
    {
        return $this->adFlag;
    }

    /**
     * @param bool $adFlag
     * @return KakaoOption
     */
    public function setAdFlag(bool $adFlag): KakaoOption
    {
        $this->adFlag = $adFlag;
        return $this;
    }

    /**
     * @return array
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    /**
     * @param array $buttons
     * @return KakaoOption
     */
    public function setButtons(array $buttons): KakaoOption
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function __construct()
    {
        $this->variables = new stdClass();
    }
}
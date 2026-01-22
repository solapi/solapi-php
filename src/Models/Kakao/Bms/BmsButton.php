<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

/**
 * BMS 버튼 모델
 * 8가지 linkType에 따라 필수/선택 필드가 달라집니다.
 *
 * - WL(웹링크): name, linkMobile 필수, linkPc, targetOut 선택
 * - AL(앱링크): name 필수, linkMobile/linkAndroid/linkIos 중 하나 이상 필수, targetOut 선택
 * - AC(채널추가): name 선택 (서버에서 삭제됨)
 * - BK(봇키워드): name 필수, chatExtra 선택
 * - MD(메시지전달): name 필수, chatExtra 선택
 * - BC(상담요청): name 필수, chatExtra 선택
 * - BT(봇전환): name 필수, chatExtra 선택
 * - BF(비즈니스폼): name 필수
 */
class BmsButton
{
    /**
     * @var string 버튼 링크 타입
     * @see BmsButtonLinkType
     */
    public $linkType;

    /**
     * @var string|null 버튼명
     */
    public $name;

    /**
     * @var string|null 모바일 링크 (WL, AL 타입용)
     */
    public $linkMobile;

    /**
     * @var string|null PC 링크 (WL, AL 타입용)
     */
    public $linkPc;

    /**
     * @var string|null 안드로이드 앱 링크 (AL 타입용)
     */
    public $linkAndroid;

    /**
     * @var string|null iOS 앱 링크 (AL 타입용)
     */
    public $linkIos;

    /**
     * @var bool|null 외부 브라우저 열기 (WL, AL 타입용)
     */
    public $targetOut;

    /**
     * @var string|null 봇에 전달할 추가 정보 (BK, MD, BC, BT 타입용)
     */
    public $chatExtra;

    /**
     * @return string
     */
    public function getLinkType(): string
    {
        return $this->linkType;
    }

    /**
     * @param string $linkType
     * @return BmsButton
     */
    public function setLinkType(string $linkType): BmsButton
    {
        $this->linkType = $linkType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return BmsButton
     */
    public function setName(?string $name): BmsButton
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLinkMobile(): ?string
    {
        return $this->linkMobile;
    }

    /**
     * @param string|null $linkMobile
     * @return BmsButton
     */
    public function setLinkMobile(?string $linkMobile): BmsButton
    {
        $this->linkMobile = $linkMobile;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLinkPc(): ?string
    {
        return $this->linkPc;
    }

    /**
     * @param string|null $linkPc
     * @return BmsButton
     */
    public function setLinkPc(?string $linkPc): BmsButton
    {
        $this->linkPc = $linkPc;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLinkAndroid(): ?string
    {
        return $this->linkAndroid;
    }

    /**
     * @param string|null $linkAndroid
     * @return BmsButton
     */
    public function setLinkAndroid(?string $linkAndroid): BmsButton
    {
        $this->linkAndroid = $linkAndroid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLinkIos(): ?string
    {
        return $this->linkIos;
    }

    /**
     * @param string|null $linkIos
     * @return BmsButton
     */
    public function setLinkIos(?string $linkIos): BmsButton
    {
        $this->linkIos = $linkIos;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getTargetOut(): ?bool
    {
        return $this->targetOut;
    }

    /**
     * @param bool|null $targetOut
     * @return BmsButton
     */
    public function setTargetOut(?bool $targetOut): BmsButton
    {
        $this->targetOut = $targetOut;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChatExtra(): ?string
    {
        return $this->chatExtra;
    }

    /**
     * @param string|null $chatExtra
     * @return BmsButton
     */
    public function setChatExtra(?string $chatExtra): BmsButton
    {
        $this->chatExtra = $chatExtra;
        return $this;
    }
}

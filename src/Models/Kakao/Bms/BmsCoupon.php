<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

/**
 * BMS 쿠폰 모델
 *
 * 쿠폰 제목 형식 (5가지):
 * - "N원 할인 쿠폰" (1~99,999,999)
 * - "N% 할인 쿠폰" (1~100)
 * - "배송비 할인 쿠폰"
 * - "OOO 무료 쿠폰" (7자 이내)
 * - "OOO UP 쿠폰" (7자 이내)
 */
class BmsCoupon
{
    /**
     * @var string 쿠폰 제목 (필수, 위 5가지 형식 중 하나)
     */
    public $title;

    /**
     * @var string 쿠폰 설명 (필수)
     */
    public $description;

    /**
     * @var string|null 모바일 링크 (선택)
     */
    public $linkMobile;

    /**
     * @var string|null PC 링크 (선택)
     */
    public $linkPc;

    /**
     * @var string|null 안드로이드 앱 링크 (선택)
     */
    public $linkAndroid;

    /**
     * @var string|null iOS 앱 링크 (선택)
     */
    public $linkIos;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return BmsCoupon
     */
    public function setTitle(string $title): BmsCoupon
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return BmsCoupon
     */
    public function setDescription(string $description): BmsCoupon
    {
        $this->description = $description;
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
     * @return BmsCoupon
     */
    public function setLinkMobile(?string $linkMobile): BmsCoupon
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
     * @return BmsCoupon
     */
    public function setLinkPc(?string $linkPc): BmsCoupon
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
     * @return BmsCoupon
     */
    public function setLinkAndroid(?string $linkAndroid): BmsCoupon
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
     * @return BmsCoupon
     */
    public function setLinkIos(?string $linkIos): BmsCoupon
    {
        $this->linkIos = $linkIos;
        return $this;
    }
}

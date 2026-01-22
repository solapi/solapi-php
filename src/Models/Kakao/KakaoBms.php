<?php

namespace Nurigo\Solapi\Models\Kakao;

use Nurigo\Solapi\Models\Kakao\Bms\BmsButton;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarousel;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCommerce;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCoupon;
use Nurigo\Solapi\Models\Kakao\Bms\BmsMainWideItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsSubWideItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsVideo;

/**
 * 카카오 BMS(브랜드 메시지 서비스) 옵션
 *
 * BMS 자유형 메시지 발송 시 chatBubbleType별 필수 필드:
 * - TEXT: (text는 Message의 text 필드 사용)
 * - IMAGE: imageId 필수
 * - WIDE: imageId 필수
 * - WIDE_ITEM_LIST: header, mainWideItem, subWideItemList(최소 3개) 필수
 * - COMMERCE: imageId, commerce, buttons 필수
 * - CAROUSEL_FEED: carousel 필수
 * - CAROUSEL_COMMERCE: carousel 필수
 * - PREMIUM_VIDEO: video 필수
 *
 * @see BmsChatBubbleType
 */
class KakaoBms
{
    /**
     * @var string 타겟팅 타입 (M, N, I)
     * M: 마케팅 수신 동의자 + 카카오 비즈니스 채널 친구 대상으로 발송
     * N: 마케팅 수신 동의자에게만 발송
     * I: 카카오 비즈니스 채널 친구에게만 발송
     * @see KakaoBmsTargetingType
     */
    public $targeting;

    /**
     * @var string|null 말풍선 타입 (TEXT, IMAGE, WIDE, WIDE_ITEM_LIST, COMMERCE, CAROUSEL_FEED, CAROUSEL_COMMERCE, PREMIUM_VIDEO)
     * @see \Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType
     */
    public $chatBubbleType;

    /** @var bool|null 성인 전용 여부 */
    public $adult;

    /** @var string|null 헤더 텍스트 (WIDE_ITEM_LIST 타입용) */
    public $header;

    /** @var string|null 이미지 ID (IMAGE, WIDE, COMMERCE 타입용) */
    public $imageId;

    /** @var string|null 이미지 클릭 시 이동 링크 */
    public $imageLink;

    /** @var string|null 추가 콘텐츠 */
    public $additionalContent;

    /** @var string|null 본문 콘텐츠 (PREMIUM_VIDEO 타입용) */
    public $content;

    /** @var BmsButton[]|null 버튼 목록 */
    public $buttons;

    /** @var BmsCoupon|null 쿠폰 정보 */
    public $coupon;

    /** @var BmsCommerce|null 커머스(상품) 정보 */
    public $commerce;

    /** @var BmsVideo|null 비디오 정보 (PREMIUM_VIDEO 타입용) */
    public $video;

    /** @var BmsCarousel|null 캐러셀 정보 (CAROUSEL_FEED, CAROUSEL_COMMERCE 타입용) */
    public $carousel;

    /** @var BmsMainWideItem|null 메인 와이드 아이템 (WIDE_ITEM_LIST 타입용) */
    public $mainWideItem;

    /** @var BmsSubWideItem[]|null 서브 와이드 아이템 목록 (WIDE_ITEM_LIST 타입용, 최소 3개) */
    public $subWideItemList;

    public function getTargeting(): string
    {
        return $this->targeting;
    }

    public function setTargeting(string $targeting): KakaoBms
    {
        $this->targeting = $targeting;
        return $this;
    }

    public function getChatBubbleType(): ?string
    {
        return $this->chatBubbleType;
    }

    public function setChatBubbleType(?string $chatBubbleType): KakaoBms
    {
        $this->chatBubbleType = $chatBubbleType;
        return $this;
    }

    public function getAdult(): ?bool
    {
        return $this->adult;
    }

    public function setAdult(?bool $adult): KakaoBms
    {
        $this->adult = $adult;
        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(?string $header): KakaoBms
    {
        $this->header = $header;
        return $this;
    }

    public function getImageId(): ?string
    {
        return $this->imageId;
    }

    public function setImageId(?string $imageId): KakaoBms
    {
        $this->imageId = $imageId;
        return $this;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(?string $imageLink): KakaoBms
    {
        $this->imageLink = $imageLink;
        return $this;
    }

    public function getAdditionalContent(): ?string
    {
        return $this->additionalContent;
    }

    public function setAdditionalContent(?string $additionalContent): KakaoBms
    {
        $this->additionalContent = $additionalContent;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): KakaoBms
    {
        $this->content = $content;
        return $this;
    }

    public function getButtons(): ?array
    {
        return $this->buttons;
    }

    public function setButtons(?array $buttons): KakaoBms
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function getCoupon(): ?BmsCoupon
    {
        return $this->coupon;
    }

    public function setCoupon(?BmsCoupon $coupon): KakaoBms
    {
        $this->coupon = $coupon;
        return $this;
    }

    public function getCommerce(): ?BmsCommerce
    {
        return $this->commerce;
    }

    public function setCommerce(?BmsCommerce $commerce): KakaoBms
    {
        $this->commerce = $commerce;
        return $this;
    }

    public function getVideo(): ?BmsVideo
    {
        return $this->video;
    }

    public function setVideo(?BmsVideo $video): KakaoBms
    {
        $this->video = $video;
        return $this;
    }

    public function getCarousel(): ?BmsCarousel
    {
        return $this->carousel;
    }

    public function setCarousel(?BmsCarousel $carousel): KakaoBms
    {
        $this->carousel = $carousel;
        return $this;
    }

    public function getMainWideItem(): ?BmsMainWideItem
    {
        return $this->mainWideItem;
    }

    public function setMainWideItem(?BmsMainWideItem $mainWideItem): KakaoBms
    {
        $this->mainWideItem = $mainWideItem;
        return $this;
    }

    public function getSubWideItemList(): ?array
    {
        return $this->subWideItemList;
    }

    public function setSubWideItemList(?array $subWideItemList): KakaoBms
    {
        $this->subWideItemList = $subWideItemList;
        return $this;
    }
}

<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

/**
 * BMS 자유형 말풍선 타입
 * 8가지 chatBubbleType을 지원합니다.
 */
class BmsChatBubbleType
{
    /**
     * 텍스트 타입
     */
    public const TEXT = 'TEXT';

    /**
     * 이미지 타입
     */
    public const IMAGE = 'IMAGE';

    /**
     * 와이드 타입
     */
    public const WIDE = 'WIDE';

    /**
     * 와이드 아이템 리스트 타입
     * subWideItemList는 최소 3개 이상 필요
     */
    public const WIDE_ITEM_LIST = 'WIDE_ITEM_LIST';

    /**
     * 커머스(상품) 타입
     */
    public const COMMERCE = 'COMMERCE';

    /**
     * 캐러셀 피드 타입
     */
    public const CAROUSEL_FEED = 'CAROUSEL_FEED';

    /**
     * 캐러셀 커머스 타입
     */
    public const CAROUSEL_COMMERCE = 'CAROUSEL_COMMERCE';

    /**
     * 프리미엄 비디오 타입
     */
    public const PREMIUM_VIDEO = 'PREMIUM_VIDEO';

    /**
     * 모든 유효한 타입 목록을 반환합니다.
     *
     * @return array
     */
    public static function values(): array
    {
        return [
            self::TEXT,
            self::IMAGE,
            self::WIDE,
            self::WIDE_ITEM_LIST,
            self::COMMERCE,
            self::CAROUSEL_FEED,
            self::CAROUSEL_COMMERCE,
            self::PREMIUM_VIDEO,
        ];
    }
}

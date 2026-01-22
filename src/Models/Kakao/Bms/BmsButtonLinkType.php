<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

/**
 * BMS 버튼 링크 타입
 * 8가지 linkType을 지원합니다.
 */
class BmsButtonLinkType
{
    /**
     * 채널 추가 버튼
     */
    public const AC = 'AC';

    /**
     * 웹 링크 버튼
     */
    public const WL = 'WL';

    /**
     * 앱 링크 버튼
     */
    public const AL = 'AL';

    /**
     * 봇 키워드 버튼
     */
    public const BK = 'BK';

    /**
     * 메시지 전달 버튼
     */
    public const MD = 'MD';

    /**
     * 상담 요청 버튼
     */
    public const BC = 'BC';

    /**
     * 봇 전환 버튼
     */
    public const BT = 'BT';

    /**
     * 비즈니스폼 버튼
     */
    public const BF = 'BF';

    /**
     * 모든 유효한 타입 목록을 반환합니다.
     *
     * @return array
     */
    public static function values(): array
    {
        return [
            self::AC,
            self::WL,
            self::AL,
            self::BK,
            self::MD,
            self::BC,
            self::BT,
            self::BF,
        ];
    }

    /**
     * 캐러셀에서 허용되는 링크 타입 목록 (WL, AL만 허용)
     *
     * @return array
     */
    public static function carouselAllowedTypes(): array
    {
        return [
            self::WL,
            self::AL,
        ];
    }
}

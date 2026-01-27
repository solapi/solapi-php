<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

use Nurigo\Solapi\Exceptions\BmsValidationException;
use Nurigo\Solapi\Models\Kakao\KakaoBms;

class BmsValidator
{
    private const WIDE_ITEM_LIST_MIN_SUB_ITEMS = 3;
    private const KAKAO_TV_URL_PREFIX = 'https://tv.kakao.com/';

    private const REQUIRED_FIELDS = [
        BmsChatBubbleType::TEXT => [],
        BmsChatBubbleType::IMAGE => ['imageId'],
        BmsChatBubbleType::WIDE => ['imageId'],
        BmsChatBubbleType::WIDE_ITEM_LIST => ['header', 'mainWideItem', 'subWideItemList'],
        BmsChatBubbleType::COMMERCE => ['imageId', 'commerce', 'buttons'],
        BmsChatBubbleType::CAROUSEL_FEED => ['carousel'],
        BmsChatBubbleType::CAROUSEL_COMMERCE => ['carousel'],
        BmsChatBubbleType::PREMIUM_VIDEO => ['video'],
    ];

    public static function validate(KakaoBms $bms): void
    {
        if ($bms->chatBubbleType === null) {
            return;
        }

        self::validateRequiredFields($bms);
        self::validateWideItemList($bms);
        self::validateCommercePricing($bms);
        self::validateVideoUrl($bms);
    }

    private static function validateRequiredFields(KakaoBms $bms): void
    {
        $requiredFields = self::REQUIRED_FIELDS[$bms->chatBubbleType] ?? [];
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if ($bms->$field === null) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            throw new BmsValidationException(
                "BMS {$bms->chatBubbleType} 타입에 필수 필드가 누락되었습니다: " . implode(', ', $missingFields)
            );
        }
    }

    private static function validateWideItemList(KakaoBms $bms): void
    {
        if ($bms->chatBubbleType !== BmsChatBubbleType::WIDE_ITEM_LIST) {
            return;
        }

        $count = $bms->subWideItemList !== null ? count($bms->subWideItemList) : 0;
        if ($count < self::WIDE_ITEM_LIST_MIN_SUB_ITEMS) {
            throw new BmsValidationException(
                "WIDE_ITEM_LIST 타입의 subWideItemList는 최소 " . self::WIDE_ITEM_LIST_MIN_SUB_ITEMS .
                "개 이상이어야 합니다. 현재: {$count}개"
            );
        }
    }

    private static function validateCommercePricing(KakaoBms $bms): void
    {
        if ($bms->commerce === null) {
            return;
        }

        $commerce = $bms->commerce;
        $hasDiscountPrice = $commerce->discountPrice !== null;
        $hasDiscountRate = $commerce->discountRate !== null;
        $hasDiscountFixed = $commerce->discountFixed !== null;

        if ($hasDiscountRate && $hasDiscountFixed) {
            throw new BmsValidationException(
                'discountRate와 discountFixed는 동시에 사용할 수 없습니다.'
            );
        }

        if (!$hasDiscountPrice && ($hasDiscountRate || $hasDiscountFixed)) {
            throw new BmsValidationException(
                'discountRate 또는 discountFixed를 사용하려면 discountPrice도 함께 지정해야 합니다.'
            );
        }

        if ($hasDiscountPrice && !$hasDiscountRate && !$hasDiscountFixed) {
            throw new BmsValidationException(
                'discountPrice를 사용하려면 discountRate 또는 discountFixed 중 하나를 함께 지정해야 합니다.'
            );
        }
    }

    private static function validateVideoUrl(KakaoBms $bms): void
    {
        if ($bms->video === null || $bms->video->videoUrl === null) {
            return;
        }

        if (strpos($bms->video->videoUrl, self::KAKAO_TV_URL_PREFIX) !== 0) {
            throw new BmsValidationException(
                "videoUrl은 '" . self::KAKAO_TV_URL_PREFIX . "'으로 시작해야 합니다."
            );
        }
    }
}

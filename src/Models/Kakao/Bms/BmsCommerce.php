<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

/**
 * BMS 커머스(상품) 정보 모델
 *
 * 가격 조합 규칙:
 * 1. regularPrice만 사용 (정가만 표기)
 * 2. regularPrice + discountPrice + discountRate (할인율 표기)
 * 3. regularPrice + discountPrice + discountFixed (정액 할인 표기)
 *
 * discountRate와 discountFixed를 동시에 사용하거나,
 * discountPrice 없이 discountRate/discountFixed만 사용하는 것은 허용되지 않습니다.
 */
class BmsCommerce
{
    /**
     * @var string 상품명 (필수)
     */
    public $title;

    /**
     * @var int|float 정가 (필수)
     */
    public $regularPrice;

    /**
     * @var int|float|null 할인가 (선택)
     */
    public $discountPrice;

    /**
     * @var int|float|null 할인율 (선택, 1-100)
     */
    public $discountRate;

    /**
     * @var int|float|null 정액 할인금액 (선택)
     */
    public $discountFixed;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return BmsCommerce
     */
    public function setTitle(string $title): BmsCommerce
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int|float
     */
    public function getRegularPrice()
    {
        return $this->regularPrice;
    }

    /**
     * @param int|float $regularPrice
     * @return BmsCommerce
     */
    public function setRegularPrice($regularPrice): BmsCommerce
    {
        $this->regularPrice = $regularPrice;
        return $this;
    }

    /**
     * @return int|float|null
     */
    public function getDiscountPrice()
    {
        return $this->discountPrice;
    }

    /**
     * @param int|float|null $discountPrice
     * @return BmsCommerce
     */
    public function setDiscountPrice($discountPrice): BmsCommerce
    {
        $this->discountPrice = $discountPrice;
        return $this;
    }

    /**
     * @return int|float|null
     */
    public function getDiscountRate()
    {
        return $this->discountRate;
    }

    /**
     * @param int|float|null $discountRate
     * @return BmsCommerce
     */
    public function setDiscountRate($discountRate): BmsCommerce
    {
        $this->discountRate = $discountRate;
        return $this;
    }

    /**
     * @return int|float|null
     */
    public function getDiscountFixed()
    {
        return $this->discountFixed;
    }

    /**
     * @param int|float|null $discountFixed
     * @return BmsCommerce
     */
    public function setDiscountFixed($discountFixed): BmsCommerce
    {
        $this->discountFixed = $discountFixed;
        return $this;
    }
}

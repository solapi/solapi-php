<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

class BmsCarouselCommerceItem
{
    /** @var BmsCommerce */
    public $commerce;

    /** @var string */
    public $imageId;

    /** @var string|null */
    public $imageLink;

    /** @var BmsButton[] */
    public $buttons;

    /** @var string|null */
    public $additionalContent;

    /** @var BmsCoupon|null */
    public $coupon;

    public function getCommerce(): BmsCommerce
    {
        return $this->commerce;
    }

    public function setCommerce(BmsCommerce $commerce): BmsCarouselCommerceItem
    {
        $this->commerce = $commerce;
        return $this;
    }

    public function getImageId(): string
    {
        return $this->imageId;
    }

    public function setImageId(string $imageId): BmsCarouselCommerceItem
    {
        $this->imageId = $imageId;
        return $this;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(?string $imageLink): BmsCarouselCommerceItem
    {
        $this->imageLink = $imageLink;
        return $this;
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function setButtons(array $buttons): BmsCarouselCommerceItem
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function getAdditionalContent(): ?string
    {
        return $this->additionalContent;
    }

    public function setAdditionalContent(?string $additionalContent): BmsCarouselCommerceItem
    {
        $this->additionalContent = $additionalContent;
        return $this;
    }

    public function getCoupon(): ?BmsCoupon
    {
        return $this->coupon;
    }

    public function setCoupon(?BmsCoupon $coupon): BmsCarouselCommerceItem
    {
        $this->coupon = $coupon;
        return $this;
    }
}

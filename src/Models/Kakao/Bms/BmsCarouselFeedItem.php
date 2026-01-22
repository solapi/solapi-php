<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

class BmsCarouselFeedItem
{
    /** @var string */
    public $header;

    /** @var string */
    public $content;

    /** @var string */
    public $imageId;

    /** @var string|null */
    public $imageLink;

    /** @var BmsButton[] */
    public $buttons;

    /** @var BmsCoupon|null */
    public $coupon;

    public function getHeader(): string
    {
        return $this->header;
    }

    public function setHeader(string $header): BmsCarouselFeedItem
    {
        $this->header = $header;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): BmsCarouselFeedItem
    {
        $this->content = $content;
        return $this;
    }

    public function getImageId(): string
    {
        return $this->imageId;
    }

    public function setImageId(string $imageId): BmsCarouselFeedItem
    {
        $this->imageId = $imageId;
        return $this;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(?string $imageLink): BmsCarouselFeedItem
    {
        $this->imageLink = $imageLink;
        return $this;
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function setButtons(array $buttons): BmsCarouselFeedItem
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function getCoupon(): ?BmsCoupon
    {
        return $this->coupon;
    }

    public function setCoupon(?BmsCoupon $coupon): BmsCarouselFeedItem
    {
        $this->coupon = $coupon;
        return $this;
    }
}

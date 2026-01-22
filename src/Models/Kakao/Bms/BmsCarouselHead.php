<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

class BmsCarouselHead
{
    /** @var string */
    public $header;

    /** @var string */
    public $content;

    /** @var string */
    public $imageId;

    /** @var string|null */
    public $linkMobile;

    /** @var string|null */
    public $linkPc;

    /** @var string|null */
    public $linkAndroid;

    /** @var string|null */
    public $linkIos;

    public function getHeader(): string
    {
        return $this->header;
    }

    public function setHeader(string $header): BmsCarouselHead
    {
        $this->header = $header;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): BmsCarouselHead
    {
        $this->content = $content;
        return $this;
    }

    public function getImageId(): string
    {
        return $this->imageId;
    }

    public function setImageId(string $imageId): BmsCarouselHead
    {
        $this->imageId = $imageId;
        return $this;
    }

    public function getLinkMobile(): ?string
    {
        return $this->linkMobile;
    }

    public function setLinkMobile(?string $linkMobile): BmsCarouselHead
    {
        $this->linkMobile = $linkMobile;
        return $this;
    }

    public function getLinkPc(): ?string
    {
        return $this->linkPc;
    }

    public function setLinkPc(?string $linkPc): BmsCarouselHead
    {
        $this->linkPc = $linkPc;
        return $this;
    }

    public function getLinkAndroid(): ?string
    {
        return $this->linkAndroid;
    }

    public function setLinkAndroid(?string $linkAndroid): BmsCarouselHead
    {
        $this->linkAndroid = $linkAndroid;
        return $this;
    }

    public function getLinkIos(): ?string
    {
        return $this->linkIos;
    }

    public function setLinkIos(?string $linkIos): BmsCarouselHead
    {
        $this->linkIos = $linkIos;
        return $this;
    }
}

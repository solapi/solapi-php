<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

class BmsSubWideItem
{
    /** @var string */
    public $title;

    /** @var string */
    public $imageId;

    /** @var string */
    public $linkMobile;

    /** @var string|null */
    public $linkPc;

    /** @var string|null */
    public $linkAndroid;

    /** @var string|null */
    public $linkIos;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): BmsSubWideItem
    {
        $this->title = $title;
        return $this;
    }

    public function getImageId(): string
    {
        return $this->imageId;
    }

    public function setImageId(string $imageId): BmsSubWideItem
    {
        $this->imageId = $imageId;
        return $this;
    }

    public function getLinkMobile(): string
    {
        return $this->linkMobile;
    }

    public function setLinkMobile(string $linkMobile): BmsSubWideItem
    {
        $this->linkMobile = $linkMobile;
        return $this;
    }

    public function getLinkPc(): ?string
    {
        return $this->linkPc;
    }

    public function setLinkPc(?string $linkPc): BmsSubWideItem
    {
        $this->linkPc = $linkPc;
        return $this;
    }

    public function getLinkAndroid(): ?string
    {
        return $this->linkAndroid;
    }

    public function setLinkAndroid(?string $linkAndroid): BmsSubWideItem
    {
        $this->linkAndroid = $linkAndroid;
        return $this;
    }

    public function getLinkIos(): ?string
    {
        return $this->linkIos;
    }

    public function setLinkIos(?string $linkIos): BmsSubWideItem
    {
        $this->linkIos = $linkIos;
        return $this;
    }
}

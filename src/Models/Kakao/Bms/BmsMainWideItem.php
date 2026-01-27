<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

class BmsMainWideItem
{
    /** @var string|null */
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): BmsMainWideItem
    {
        $this->title = $title;
        return $this;
    }

    public function getImageId(): string
    {
        return $this->imageId;
    }

    public function setImageId(string $imageId): BmsMainWideItem
    {
        $this->imageId = $imageId;
        return $this;
    }

    public function getLinkMobile(): string
    {
        return $this->linkMobile;
    }

    public function setLinkMobile(string $linkMobile): BmsMainWideItem
    {
        $this->linkMobile = $linkMobile;
        return $this;
    }

    public function getLinkPc(): ?string
    {
        return $this->linkPc;
    }

    public function setLinkPc(?string $linkPc): BmsMainWideItem
    {
        $this->linkPc = $linkPc;
        return $this;
    }

    public function getLinkAndroid(): ?string
    {
        return $this->linkAndroid;
    }

    public function setLinkAndroid(?string $linkAndroid): BmsMainWideItem
    {
        $this->linkAndroid = $linkAndroid;
        return $this;
    }

    public function getLinkIos(): ?string
    {
        return $this->linkIos;
    }

    public function setLinkIos(?string $linkIos): BmsMainWideItem
    {
        $this->linkIos = $linkIos;
        return $this;
    }
}

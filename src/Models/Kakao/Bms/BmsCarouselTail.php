<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

class BmsCarouselTail
{
    /** @var string */
    public $linkMobile;

    /** @var string|null */
    public $linkPc;

    /** @var string|null */
    public $linkAndroid;

    /** @var string|null */
    public $linkIos;

    public function getLinkMobile(): string
    {
        return $this->linkMobile;
    }

    public function setLinkMobile(string $linkMobile): BmsCarouselTail
    {
        $this->linkMobile = $linkMobile;
        return $this;
    }

    public function getLinkPc(): ?string
    {
        return $this->linkPc;
    }

    public function setLinkPc(?string $linkPc): BmsCarouselTail
    {
        $this->linkPc = $linkPc;
        return $this;
    }

    public function getLinkAndroid(): ?string
    {
        return $this->linkAndroid;
    }

    public function setLinkAndroid(?string $linkAndroid): BmsCarouselTail
    {
        $this->linkAndroid = $linkAndroid;
        return $this;
    }

    public function getLinkIos(): ?string
    {
        return $this->linkIos;
    }

    public function setLinkIos(?string $linkIos): BmsCarouselTail
    {
        $this->linkIos = $linkIos;
        return $this;
    }
}

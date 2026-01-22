<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

class BmsCarousel
{
    /** @var BmsCarouselHead|null */
    public $head;

    /** @var BmsCarouselFeedItem[]|BmsCarouselCommerceItem[] */
    public $list;

    /** @var BmsCarouselTail|null */
    public $tail;

    public function getHead(): ?BmsCarouselHead
    {
        return $this->head;
    }

    public function setHead(?BmsCarouselHead $head): BmsCarousel
    {
        $this->head = $head;
        return $this;
    }

    public function getList(): array
    {
        return $this->list;
    }

    public function setList(array $list): BmsCarousel
    {
        $this->list = $list;
        return $this;
    }

    public function getTail(): ?BmsCarouselTail
    {
        return $this->tail;
    }

    public function setTail(?BmsCarouselTail $tail): BmsCarousel
    {
        $this->tail = $tail;
        return $this;
    }
}

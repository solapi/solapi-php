<?php

namespace Nurigo\Solapi\Tests\Models\Kakao\Bms;

use Nurigo\Solapi\Models\Kakao\Bms\BmsButton;
use Nurigo\Solapi\Models\Kakao\Bms\BmsButtonLinkType;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarousel;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarouselCommerceItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarouselFeedItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarouselHead;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarouselTail;
use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCommerce;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCoupon;
use Nurigo\Solapi\Models\Kakao\Bms\BmsMainWideItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsSubWideItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsVideo;
use PHPUnit\Framework\TestCase;

class BmsModelsTest extends TestCase
{
    public function testBmsChatBubbleTypeValues(): void
    {
        $values = BmsChatBubbleType::values();

        $this->assertCount(8, $values);
        $this->assertContains('TEXT', $values);
        $this->assertContains('IMAGE', $values);
        $this->assertContains('WIDE', $values);
        $this->assertContains('WIDE_ITEM_LIST', $values);
        $this->assertContains('COMMERCE', $values);
        $this->assertContains('CAROUSEL_FEED', $values);
        $this->assertContains('CAROUSEL_COMMERCE', $values);
        $this->assertContains('PREMIUM_VIDEO', $values);
    }

    public function testBmsButtonLinkTypeValues(): void
    {
        $values = BmsButtonLinkType::values();

        $this->assertCount(8, $values);
        $this->assertContains('AC', $values);
        $this->assertContains('WL', $values);
        $this->assertContains('AL', $values);
        $this->assertContains('BK', $values);
        $this->assertContains('MD', $values);
        $this->assertContains('BC', $values);
        $this->assertContains('BT', $values);
        $this->assertContains('BF', $values);
    }

    public function testBmsButtonLinkTypeCarouselAllowedTypes(): void
    {
        $allowed = BmsButtonLinkType::carouselAllowedTypes();

        $this->assertCount(2, $allowed);
        $this->assertContains('WL', $allowed);
        $this->assertContains('AL', $allowed);
    }

    public function testBmsButtonFluentSetters(): void
    {
        $button = new BmsButton();
        $result = $button
            ->setLinkType('WL')
            ->setName('Test Button')
            ->setLinkMobile('https://m.example.com')
            ->setLinkPc('https://example.com')
            ->setTargetOut(true);

        $this->assertSame($button, $result);
        $this->assertEquals('WL', $button->getLinkType());
        $this->assertEquals('Test Button', $button->getName());
        $this->assertEquals('https://m.example.com', $button->getLinkMobile());
        $this->assertEquals('https://example.com', $button->getLinkPc());
        $this->assertTrue($button->getTargetOut());
    }

    public function testBmsButtonAppLinkProperties(): void
    {
        $button = new BmsButton();
        $button
            ->setLinkType('AL')
            ->setName('App Button')
            ->setLinkMobile('https://m.example.com')
            ->setLinkAndroid('app://android')
            ->setLinkIos('app://ios')
            ->setChatExtra('extra-data');

        $this->assertEquals('AL', $button->getLinkType());
        $this->assertEquals('app://android', $button->getLinkAndroid());
        $this->assertEquals('app://ios', $button->getLinkIos());
        $this->assertEquals('extra-data', $button->getChatExtra());
    }

    public function testBmsCommerceFluentSetters(): void
    {
        $commerce = new BmsCommerce();
        $result = $commerce
            ->setTitle('Test Product')
            ->setRegularPrice(50000)
            ->setDiscountPrice(40000)
            ->setDiscountRate(20)
            ->setDiscountFixed(null);

        $this->assertSame($commerce, $result);
        $this->assertEquals('Test Product', $commerce->getTitle());
        $this->assertEquals(50000, $commerce->getRegularPrice());
        $this->assertEquals(40000, $commerce->getDiscountPrice());
        $this->assertEquals(20, $commerce->getDiscountRate());
        $this->assertNull($commerce->getDiscountFixed());
    }

    public function testBmsCouponFluentSetters(): void
    {
        $coupon = new BmsCoupon();
        $result = $coupon
            ->setTitle('10000원 할인 쿠폰')
            ->setDescription('First purchase discount')
            ->setLinkMobile('https://m.example.com/coupon')
            ->setLinkPc('https://example.com/coupon')
            ->setLinkAndroid('app://coupon')
            ->setLinkIos('app://coupon');

        $this->assertSame($coupon, $result);
        $this->assertEquals('10000원 할인 쿠폰', $coupon->getTitle());
        $this->assertEquals('First purchase discount', $coupon->getDescription());
        $this->assertEquals('https://m.example.com/coupon', $coupon->getLinkMobile());
    }

    public function testBmsVideoFluentSetters(): void
    {
        $video = new BmsVideo();
        $result = $video
            ->setVideoUrl('https://tv.kakao.com/v/123456')
            ->setImageId('thumbnail-id')
            ->setImageLink('https://example.com/video');

        $this->assertSame($video, $result);
        $this->assertEquals('https://tv.kakao.com/v/123456', $video->getVideoUrl());
        $this->assertEquals('thumbnail-id', $video->getImageId());
        $this->assertEquals('https://example.com/video', $video->getImageLink());
    }

    public function testBmsMainWideItemFluentSetters(): void
    {
        $item = new BmsMainWideItem();
        $result = $item
            ->setTitle('Main Item')
            ->setImageId('main-image')
            ->setLinkMobile('https://m.example.com')
            ->setLinkPc('https://example.com')
            ->setLinkAndroid('app://android')
            ->setLinkIos('app://ios');

        $this->assertSame($item, $result);
        $this->assertEquals('Main Item', $item->getTitle());
        $this->assertEquals('main-image', $item->getImageId());
        $this->assertEquals('https://m.example.com', $item->getLinkMobile());
    }

    public function testBmsSubWideItemFluentSetters(): void
    {
        $item = new BmsSubWideItem();
        $result = $item
            ->setTitle('Sub Item')
            ->setImageId('sub-image')
            ->setLinkMobile('https://m.example.com');

        $this->assertSame($item, $result);
        $this->assertEquals('Sub Item', $item->getTitle());
        $this->assertEquals('sub-image', $item->getImageId());
        $this->assertEquals('https://m.example.com', $item->getLinkMobile());
    }

    public function testBmsCarouselHeadFluentSetters(): void
    {
        $head = new BmsCarouselHead();
        $result = $head
            ->setHeader('Carousel Header')
            ->setContent('Carousel description')
            ->setImageId('header-image')
            ->setLinkMobile('https://m.example.com');

        $this->assertSame($head, $result);
        $this->assertEquals('Carousel Header', $head->getHeader());
        $this->assertEquals('Carousel description', $head->getContent());
        $this->assertEquals('header-image', $head->getImageId());
    }

    public function testBmsCarouselTailFluentSetters(): void
    {
        $tail = new BmsCarouselTail();
        $result = $tail
            ->setLinkMobile('https://m.example.com/more')
            ->setLinkPc('https://example.com/more');

        $this->assertSame($tail, $result);
        $this->assertEquals('https://m.example.com/more', $tail->getLinkMobile());
        $this->assertEquals('https://example.com/more', $tail->getLinkPc());
    }

    public function testBmsCarouselFeedItemFluentSetters(): void
    {
        $button = new BmsButton();
        $button->setLinkType('WL')->setName('View')->setLinkMobile('https://m.example.com');

        $coupon = new BmsCoupon();
        $coupon->setTitle('10% 할인 쿠폰')->setDescription('Discount');

        $item = new BmsCarouselFeedItem();
        $result = $item
            ->setHeader('Feed Item Header')
            ->setContent('Feed item content')
            ->setImageId('feed-image')
            ->setImageLink('https://example.com/image')
            ->setButtons([$button])
            ->setCoupon($coupon);

        $this->assertSame($item, $result);
        $this->assertEquals('Feed Item Header', $item->getHeader());
        $this->assertEquals('Feed item content', $item->getContent());
        $this->assertCount(1, $item->getButtons());
        $this->assertNotNull($item->getCoupon());
    }

    public function testBmsCarouselCommerceItemFluentSetters(): void
    {
        $commerce = new BmsCommerce();
        $commerce->setTitle('Product')->setRegularPrice(10000);

        $button = new BmsButton();
        $button->setLinkType('WL')->setName('Buy')->setLinkMobile('https://m.example.com');

        $item = new BmsCarouselCommerceItem();
        $result = $item
            ->setCommerce($commerce)
            ->setImageId('product-image')
            ->setImageLink('https://example.com/product')
            ->setButtons([$button])
            ->setAdditionalContent('Free shipping')
            ->setCoupon(null);

        $this->assertSame($item, $result);
        $this->assertNotNull($item->getCommerce());
        $this->assertEquals('Product', $item->getCommerce()->getTitle());
        $this->assertEquals('Free shipping', $item->getAdditionalContent());
    }

    public function testBmsCarouselFluentSetters(): void
    {
        $head = new BmsCarouselHead();
        $head->setHeader('Header')->setContent('Content')->setImageId('head-img');

        $feedItem = new BmsCarouselFeedItem();
        $feedItem->setHeader('Item')->setContent('Content')->setImageId('item-img')->setButtons([]);

        $tail = new BmsCarouselTail();
        $tail->setLinkMobile('https://m.example.com/more');

        $carousel = new BmsCarousel();
        $result = $carousel
            ->setHead($head)
            ->setList([$feedItem])
            ->setTail($tail);

        $this->assertSame($carousel, $result);
        $this->assertNotNull($carousel->getHead());
        $this->assertCount(1, $carousel->getList());
        $this->assertNotNull($carousel->getTail());
    }
}

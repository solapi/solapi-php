<?php

namespace Nurigo\Solapi\Tests\Models\Kakao\Bms;

use Nurigo\Solapi\Exceptions\BmsValidationException;
use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCommerce;
use Nurigo\Solapi\Models\Kakao\Bms\BmsMainWideItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsSubWideItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsValidator;
use Nurigo\Solapi\Models\Kakao\Bms\BmsVideo;
use Nurigo\Solapi\Models\Kakao\Bms\BmsButton;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarousel;
use Nurigo\Solapi\Models\Kakao\KakaoBms;
use PHPUnit\Framework\TestCase;

class BmsValidatorTest extends TestCase
{
    public function testTextTypeValidation(): void
    {
        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::TEXT);

        BmsValidator::validate($bms);
        $this->assertTrue(true);
    }

    public function testImageTypeRequiresImageId(): void
    {
        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::IMAGE);

        $this->expectException(BmsValidationException::class);
        $this->expectExceptionMessage('imageId');
        BmsValidator::validate($bms);
    }

    public function testImageTypePassesWithImageId(): void
    {
        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::IMAGE)
            ->setImageId('test-image-id');

        BmsValidator::validate($bms);
        $this->assertTrue(true);
    }

    public function testWideItemListRequiresMinimumThreeSubItems(): void
    {
        $mainItem = new BmsMainWideItem();
        $mainItem->setImageId('img1')->setLinkMobile('https://example.com');

        $subItem1 = new BmsSubWideItem();
        $subItem1->setTitle('Item 1')->setImageId('img1')->setLinkMobile('https://example.com');

        $subItem2 = new BmsSubWideItem();
        $subItem2->setTitle('Item 2')->setImageId('img2')->setLinkMobile('https://example.com');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::WIDE_ITEM_LIST)
            ->setHeader('Test Header')
            ->setMainWideItem($mainItem)
            ->setSubWideItemList([$subItem1, $subItem2]);

        $this->expectException(BmsValidationException::class);
        $this->expectExceptionMessage('최소 3개');
        BmsValidator::validate($bms);
    }

    public function testWideItemListPassesWithThreeSubItems(): void
    {
        $mainItem = new BmsMainWideItem();
        $mainItem->setImageId('img1')->setLinkMobile('https://example.com');

        $subItems = [];
        for ($i = 1; $i <= 3; $i++) {
            $subItem = new BmsSubWideItem();
            $subItem->setTitle("Item $i")->setImageId("img$i")->setLinkMobile('https://example.com');
            $subItems[] = $subItem;
        }

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::WIDE_ITEM_LIST)
            ->setHeader('Test Header')
            ->setMainWideItem($mainItem)
            ->setSubWideItemList($subItems);

        BmsValidator::validate($bms);
        $this->assertTrue(true);
    }

    public function testCommerceTypeRequiresFields(): void
    {
        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::COMMERCE);

        $this->expectException(BmsValidationException::class);
        BmsValidator::validate($bms);
    }

    public function testCommerceTypePassesWithAllFields(): void
    {
        $commerce = new BmsCommerce();
        $commerce->setTitle('Test Product')->setRegularPrice(10000);

        $button = new BmsButton();
        $button->setLinkType('WL')->setName('Buy')->setLinkMobile('https://example.com');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::COMMERCE)
            ->setImageId('test-image')
            ->setCommerce($commerce)
            ->setButtons([$button]);

        BmsValidator::validate($bms);
        $this->assertTrue(true);
    }

    public function testCommercePricingCannotUseBothDiscountRateAndFixed(): void
    {
        $commerce = new BmsCommerce();
        $commerce->setTitle('Test Product')
            ->setRegularPrice(10000)
            ->setDiscountPrice(8000)
            ->setDiscountRate(20)
            ->setDiscountFixed(2000);

        $button = new BmsButton();
        $button->setLinkType('WL')->setName('Buy')->setLinkMobile('https://example.com');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::COMMERCE)
            ->setImageId('test-image')
            ->setCommerce($commerce)
            ->setButtons([$button]);

        $this->expectException(BmsValidationException::class);
        $this->expectExceptionMessage('discountRate와 discountFixed는 동시에 사용할 수 없습니다');
        BmsValidator::validate($bms);
    }

    public function testCommercePricingRequiresDiscountPriceWithDiscountRate(): void
    {
        $commerce = new BmsCommerce();
        $commerce->setTitle('Test Product')
            ->setRegularPrice(10000)
            ->setDiscountRate(20);

        $button = new BmsButton();
        $button->setLinkType('WL')->setName('Buy')->setLinkMobile('https://example.com');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::COMMERCE)
            ->setImageId('test-image')
            ->setCommerce($commerce)
            ->setButtons([$button]);

        $this->expectException(BmsValidationException::class);
        $this->expectExceptionMessage('discountPrice도 함께 지정해야 합니다');
        BmsValidator::validate($bms);
    }

    public function testCommercePricingRequiresDiscountTypeWithDiscountPrice(): void
    {
        $commerce = new BmsCommerce();
        $commerce->setTitle('Test Product')
            ->setRegularPrice(10000)
            ->setDiscountPrice(8000);

        $button = new BmsButton();
        $button->setLinkType('WL')->setName('Buy')->setLinkMobile('https://example.com');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::COMMERCE)
            ->setImageId('test-image')
            ->setCommerce($commerce)
            ->setButtons([$button]);

        $this->expectException(BmsValidationException::class);
        $this->expectExceptionMessage('discountRate 또는 discountFixed 중 하나를 함께 지정해야 합니다');
        BmsValidator::validate($bms);
    }

    public function testCommercePricingPassesWithValidDiscountRate(): void
    {
        $commerce = new BmsCommerce();
        $commerce->setTitle('Test Product')
            ->setRegularPrice(10000)
            ->setDiscountPrice(8000)
            ->setDiscountRate(20);

        $button = new BmsButton();
        $button->setLinkType('WL')->setName('Buy')->setLinkMobile('https://example.com');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::COMMERCE)
            ->setImageId('test-image')
            ->setCommerce($commerce)
            ->setButtons([$button]);

        BmsValidator::validate($bms);
        $this->assertTrue(true);
    }

    public function testCommercePricingPassesWithValidDiscountFixed(): void
    {
        $commerce = new BmsCommerce();
        $commerce->setTitle('Test Product')
            ->setRegularPrice(10000)
            ->setDiscountPrice(8000)
            ->setDiscountFixed(2000);

        $button = new BmsButton();
        $button->setLinkType('WL')->setName('Buy')->setLinkMobile('https://example.com');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::COMMERCE)
            ->setImageId('test-image')
            ->setCommerce($commerce)
            ->setButtons([$button]);

        BmsValidator::validate($bms);
        $this->assertTrue(true);
    }

    public function testPremiumVideoRequiresKakaoTvUrl(): void
    {
        $video = new BmsVideo();
        $video->setVideoUrl('https://youtube.com/watch?v=123');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::PREMIUM_VIDEO)
            ->setVideo($video);

        $this->expectException(BmsValidationException::class);
        $this->expectExceptionMessage('https://tv.kakao.com/');
        BmsValidator::validate($bms);
    }

    public function testPremiumVideoPassesWithKakaoTvUrl(): void
    {
        $video = new BmsVideo();
        $video->setVideoUrl('https://tv.kakao.com/v/123456');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::PREMIUM_VIDEO)
            ->setVideo($video);

        BmsValidator::validate($bms);
        $this->assertTrue(true);
    }

    public function testCarouselFeedRequiresCarousel(): void
    {
        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::CAROUSEL_FEED);

        $this->expectException(BmsValidationException::class);
        $this->expectExceptionMessage('carousel');
        BmsValidator::validate($bms);
    }

    public function testCarouselFeedPassesWithCarousel(): void
    {
        $carousel = new BmsCarousel();
        $carousel->setList([]);

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::CAROUSEL_FEED)
            ->setCarousel($carousel);

        BmsValidator::validate($bms);
        $this->assertTrue(true);
    }

    public function testNullChatBubbleTypeSkipsValidation(): void
    {
        $bms = new KakaoBms();
        $bms->setTargeting('I');

        BmsValidator::validate($bms);
        $this->assertTrue(true);
    }
}

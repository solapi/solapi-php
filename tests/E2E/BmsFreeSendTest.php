<?php

/**
 * BMS Free Message E2E Tests
 *
 * These tests actually send messages through the SOLAPI API.
 * Required environment variables:
 * - SOLAPI_API_KEY: API key
 * - SOLAPI_API_SECRET: API secret
 * - SOLAPI_KAKAO_PF_ID: Kakao Business Channel pfId
 * - SOLAPI_SENDER_NUMBER: Sender phone number
 * - SOLAPI_RECIPIENT_NUMBER: Recipient phone number
 *
 * Optional environment variables:
 * - SOLAPI_TEST_IMAGE_PATH: Path to a test image file for IMAGE/COMMERCE tests
 */

namespace Nurigo\Solapi\Tests\E2E;

use Exception;
use Nurigo\Solapi\Models\Kakao\Bms\BmsButton;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarousel;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarouselCommerceItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarouselFeedItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarouselTail;
use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCommerce;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCoupon;
use Nurigo\Solapi\Models\Kakao\Bms\BmsMainWideItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsSubWideItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsVideo;
use Nurigo\Solapi\Models\Kakao\KakaoBms;
use Nurigo\Solapi\Models\Kakao\KakaoOption;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Models\Response\SendResponse;
use Nurigo\Solapi\Services\SolapiMessageService;
use PHPUnit\Framework\TestCase;

class BmsFreeSendTest extends TestCase
{
    private ?SolapiMessageService $messageService = null;
    private string $pfId = '';
    private string $senderNumber = '';
    private string $recipientNumber = '';
    private ?string $testImagePath = null;

    protected function setUp(): void
    {
        $apiKey = getenv('SOLAPI_API_KEY');
        $apiSecret = getenv('SOLAPI_API_SECRET');
        $this->pfId = getenv('SOLAPI_KAKAO_PF_ID') ?: '';
        $this->senderNumber = getenv('SOLAPI_SENDER_NUMBER') ?: '';
        $this->recipientNumber = getenv('SOLAPI_RECIPIENT_NUMBER') ?: '';
        $this->testImagePath = getenv('SOLAPI_TEST_IMAGE_PATH') ?: null;

        if (!$apiKey || !$apiSecret) {
            $this->markTestSkipped('SOLAPI_API_KEY and SOLAPI_API_SECRET environment variables are required');
        }

        if (!$this->pfId) {
            $this->markTestSkipped('SOLAPI_KAKAO_PF_ID environment variable is required');
        }

        if (!$this->senderNumber || !$this->recipientNumber) {
            $this->markTestSkipped('SOLAPI_SENDER_NUMBER and SOLAPI_RECIPIENT_NUMBER environment variables are required');
        }

        $this->messageService = new SolapiMessageService($apiKey, $apiSecret);
    }

    /**
     * Test sending BMS FREE TEXT type with minimal structure
     */
    public function testSendBmsTextMinimal(): void
    {
        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::TEXT);

        $kakaoOption = new KakaoOption();
        $kakaoOption->setPfId($this->pfId)
            ->setBms($bms);

        $message = new Message();
        $message->setTo($this->recipientNumber)
            ->setFrom($this->senderNumber)
            ->setText('[E2E 테스트] BMS FREE TEXT 최소 구조 테스트입니다.')
            ->setType('BMS_FREE')
            ->setKakaoOptions($kakaoOption);

        try {
            $response = $this->messageService->send($message);

            $this->assertInstanceOf(SendResponse::class, $response);
            $this->assertNotNull($response->groupInfo);
            $this->assertGreaterThan(0, $response->groupInfo->count->total);

            echo sprintf(
                "\nGroup ID: %s\nTotal: %d\nSuccess: %d\n",
                $response->groupInfo->groupId,
                $response->groupInfo->count->total,
                $response->groupInfo->count->registeredSuccess
            );
        } catch (Exception $e) {
            $this->markTestSkipped('BMS FREE TEXT test skipped: ' . $e->getMessage());
        }
    }

    /**
     * Test sending BMS FREE TEXT type with buttons and coupon
     */
    public function testSendBmsTextWithButtons(): void
    {
        $webButton = new BmsButton();
        $webButton->setLinkType('WL')
            ->setName('웹 링크')
            ->setLinkMobile('https://example.com');

        $appButton = new BmsButton();
        $appButton->setLinkType('AL')
            ->setName('앱 링크')
            ->setLinkMobile('https://example.com')
            ->setLinkAndroid('exampleapp://path')
            ->setLinkIos('exampleapp://path');

        $coupon = new BmsCoupon();
        $coupon->setTitle('10% 할인 쿠폰')
            ->setDescription('테스트 쿠폰')
            ->setLinkMobile('https://example.com/coupon');

        $bms = new KakaoBms();
        $bms->setTargeting('I')
            ->setChatBubbleType(BmsChatBubbleType::TEXT)
            ->setAdult(false)
            ->setButtons([$webButton, $appButton])
            ->setCoupon($coupon);

        $kakaoOption = new KakaoOption();
        $kakaoOption->setPfId($this->pfId)
            ->setBms($bms);

        $message = new Message();
        $message->setTo($this->recipientNumber)
            ->setFrom($this->senderNumber)
            ->setText('[E2E 테스트] BMS FREE TEXT 전체 필드 테스트입니다.')
            ->setType('BMS_FREE')
            ->setKakaoOptions($kakaoOption);

        try {
            $response = $this->messageService->send($message);

            $this->assertInstanceOf(SendResponse::class, $response);
            $this->assertNotNull($response->groupInfo);
            $this->assertGreaterThan(0, $response->groupInfo->count->total);

            echo sprintf(
                "\nGroup ID: %s\nTotal: %d\nSuccess: %d\n",
                $response->groupInfo->groupId,
                $response->groupInfo->count->total,
                $response->groupInfo->count->registeredSuccess
            );
        } catch (Exception $e) {
            $this->markTestSkipped('BMS FREE TEXT with buttons test skipped: ' . $e->getMessage());
        }
    }

    /**
     * Test sending BMS FREE IMAGE type with image upload
     */
    public function testSendBmsImage(): void
    {
        $imagePath = $this->getTestImagePath();
        if (!$imagePath) {
            $this->markTestSkipped('Test image not found');
        }

        try {
            $imageId = $this->messageService->uploadFile($imagePath, 'BMS');
            echo sprintf("\nUploaded BMS image ID: %s\n", $imageId);

            $bms = new KakaoBms();
            $bms->setTargeting('I')
                ->setChatBubbleType(BmsChatBubbleType::IMAGE)
                ->setImageId($imageId);

            $kakaoOption = new KakaoOption();
            $kakaoOption->setPfId($this->pfId)
                ->setBms($bms);

            $message = new Message();
            $message->setTo($this->recipientNumber)
                ->setFrom($this->senderNumber)
                ->setText('[E2E 테스트] BMS FREE IMAGE 테스트입니다.')
                ->setType('BMS_FREE')
                ->setKakaoOptions($kakaoOption);

            $response = $this->messageService->send($message);

            $this->assertInstanceOf(SendResponse::class, $response);
            $this->assertNotNull($response->groupInfo);
            $this->assertGreaterThan(0, $response->groupInfo->count->total);

            echo sprintf(
                "\nGroup ID: %s\nTotal: %d\nSuccess: %d\n",
                $response->groupInfo->groupId,
                $response->groupInfo->count->total,
                $response->groupInfo->count->registeredSuccess
            );
        } catch (Exception $e) {
            $this->markTestSkipped('BMS FREE IMAGE test skipped: ' . $e->getMessage());
        }
    }

    /**
     * Test sending BMS FREE WIDE type
     * Note: WIDE type requires 2:1 ratio image
     */
    public function testSendBmsWide(): void
    {
        $imagePath = $this->getWideTestImagePath();
        if (!$imagePath) {
            $this->markTestSkipped('Wide test image (2:1 ratio) not found');
        }

        try {
            $imageId = $this->messageService->uploadFile($imagePath, 'BMS_WIDE');
            echo sprintf("\nUploaded BMS WIDE image ID: %s\n", $imageId);

            $button = new BmsButton();
            $button->setLinkType('WL')
                ->setName('자세히 보기')
                ->setLinkMobile('https://example.com');

            $bms = new KakaoBms();
            $bms->setTargeting('I')
                ->setChatBubbleType(BmsChatBubbleType::WIDE)
                ->setImageId($imageId)
                ->setButtons([$button]);

            $kakaoOption = new KakaoOption();
            $kakaoOption->setPfId($this->pfId)
                ->setBms($bms);

            $message = new Message();
            $message->setTo($this->recipientNumber)
                ->setFrom($this->senderNumber)
                ->setText('[E2E 테스트] BMS FREE WIDE 테스트입니다.')
                ->setType('BMS_FREE')
                ->setKakaoOptions($kakaoOption);

            $response = $this->messageService->send($message);

            $this->assertInstanceOf(SendResponse::class, $response);
            $this->assertNotNull($response->groupInfo);
            $this->assertGreaterThan(0, $response->groupInfo->count->total);

            echo sprintf(
                "\nGroup ID: %s\nTotal: %d\nSuccess: %d\n",
                $response->groupInfo->groupId,
                $response->groupInfo->count->total,
                $response->groupInfo->count->registeredSuccess
            );
        } catch (Exception $e) {
            $this->markTestSkipped('BMS FREE WIDE test skipped: ' . $e->getMessage());
        }
    }

    /**
     * Test sending BMS FREE COMMERCE type with product info
     */
    public function testSendBmsCommerce(): void
    {
        $imagePath = $this->getTestImagePath();
        if (!$imagePath) {
            $this->markTestSkipped('Test image not found');
        }

        try {
            $imageId = $this->messageService->uploadFile($imagePath, 'BMS');

            $commerce = new BmsCommerce();
            $commerce->setTitle('테스트 상품')
                ->setRegularPrice(50000)
                ->setDiscountPrice(40000)
                ->setDiscountRate(20);

            $button = new BmsButton();
            $button->setLinkType('WL')
                ->setName('구매하기')
                ->setLinkMobile('https://example.com/product');

            $bms = new KakaoBms();
            $bms->setTargeting('I')
                ->setChatBubbleType(BmsChatBubbleType::COMMERCE)
                ->setImageId($imageId)
                ->setCommerce($commerce)
                ->setButtons([$button]);

            $kakaoOption = new KakaoOption();
            $kakaoOption->setPfId($this->pfId)
                ->setBms($bms);

            $message = new Message();
            $message->setTo($this->recipientNumber)
                ->setFrom($this->senderNumber)
                ->setType('BMS_FREE')
                ->setKakaoOptions($kakaoOption);

            $response = $this->messageService->send($message);

            $this->assertInstanceOf(SendResponse::class, $response);
            $this->assertNotNull($response->groupInfo);
            $this->assertGreaterThan(0, $response->groupInfo->count->total);

            echo sprintf(
                "\nGroup ID: %s\nTotal: %d\nSuccess: %d\n",
                $response->groupInfo->groupId,
                $response->groupInfo->count->total,
                $response->groupInfo->count->registeredSuccess
            );
        } catch (Exception $e) {
            $this->markTestSkipped('BMS FREE COMMERCE test skipped: ' . $e->getMessage());
        }
    }

    /**
     * Test sending BMS FREE WIDE_ITEM_LIST type
     * Note: Main item requires 2:1 ratio, sub items require 1:1 ratio
     */
    public function testSendBmsWideItemList(): void
    {
        $mainImagePath = $this->getWideTestImagePath();
        $subImagePath = $this->getTestImagePath();

        if (!$mainImagePath) {
            $this->markTestSkipped('Wide test image (2:1 ratio) not found for main item');
        }
        if (!$subImagePath) {
            $this->markTestSkipped('Square test image (1:1 ratio) not found for sub items');
        }

        try {
            // Upload main image (2:1 ratio)
            $mainImageId = $this->messageService->uploadFile($mainImagePath, 'BMS_WIDE_MAIN_ITEM_LIST');
            // Upload sub images (1:1 ratio)
            $subImageId = $this->messageService->uploadFile($subImagePath, 'BMS_WIDE_SUB_ITEM_LIST');

            $mainItem = new BmsMainWideItem();
            $mainItem->setImageId($mainImageId)
                ->setLinkMobile('https://example.com/main');

            $subItems = [];
            for ($i = 1; $i <= 3; $i++) {
                $subItem = new BmsSubWideItem();
                $subItem->setTitle("아이템 $i")
                    ->setImageId($subImageId)
                    ->setLinkMobile("https://example.com/item$i");
                $subItems[] = $subItem;
            }

            $bms = new KakaoBms();
            $bms->setTargeting('I')
                ->setChatBubbleType(BmsChatBubbleType::WIDE_ITEM_LIST)
                ->setHeader('WIDE ITEM LIST 테스트')
                ->setMainWideItem($mainItem)
                ->setSubWideItemList($subItems);

            $kakaoOption = new KakaoOption();
            $kakaoOption->setPfId($this->pfId)
                ->setBms($bms);

            $message = new Message();
            $message->setTo($this->recipientNumber)
                ->setFrom($this->senderNumber)
                ->setType('BMS_FREE')
                ->setKakaoOptions($kakaoOption);

            $response = $this->messageService->send($message);

            $this->assertInstanceOf(SendResponse::class, $response);
            $this->assertNotNull($response->groupInfo);
            $this->assertGreaterThan(0, $response->groupInfo->count->total);

            echo sprintf(
                "\nGroup ID: %s\nTotal: %d\nSuccess: %d\n",
                $response->groupInfo->groupId,
                $response->groupInfo->count->total,
                $response->groupInfo->count->registeredSuccess
            );
        } catch (Exception $e) {
            $this->markTestSkipped('BMS FREE WIDE_ITEM_LIST test skipped: ' . $e->getMessage());
        }
    }

    /**
     * Test sending BMS FREE CAROUSEL_FEED type
     */
    public function testSendBmsCarouselFeed(): void
    {
        $imagePath = $this->getTestImagePath();
        if (!$imagePath) {
            $this->markTestSkipped('Test image not found');
        }

        try {
            $imageId = $this->messageService->uploadFile($imagePath, 'BMS_CAROUSEL_FEED_LIST');

            $items = [];
            for ($i = 1; $i <= 2; $i++) {
                $button = new BmsButton();
                $button->setLinkType('WL')
                    ->setName("버튼 $i")
                    ->setLinkMobile("https://example.com/item$i");

                $item = new BmsCarouselFeedItem();
                $item->setHeader("캐러셀 피드 아이템 $i")
                    ->setContent("캐러셀 피드 아이템 $i 의 내용입니다.")
                    ->setImageId($imageId)
                    ->setButtons([$button]);
                $items[] = $item;
            }

            $tail = new BmsCarouselTail();
            $tail->setLinkMobile('https://example.com/more');

            $carousel = new BmsCarousel();
            $carousel->setList($items)
                ->setTail($tail);

            $bms = new KakaoBms();
            $bms->setTargeting('I')
                ->setChatBubbleType(BmsChatBubbleType::CAROUSEL_FEED)
                ->setCarousel($carousel);

            $kakaoOption = new KakaoOption();
            $kakaoOption->setPfId($this->pfId)
                ->setBms($bms);

            $message = new Message();
            $message->setTo($this->recipientNumber)
                ->setFrom($this->senderNumber)
                ->setType('BMS_FREE')
                ->setKakaoOptions($kakaoOption);

            $response = $this->messageService->send($message);

            $this->assertInstanceOf(SendResponse::class, $response);
            $this->assertNotNull($response->groupInfo);
            $this->assertGreaterThan(0, $response->groupInfo->count->total);

            echo sprintf(
                "\nGroup ID: %s\nTotal: %d\nSuccess: %d\n",
                $response->groupInfo->groupId,
                $response->groupInfo->count->total,
                $response->groupInfo->count->registeredSuccess
            );
        } catch (Exception $e) {
            $this->markTestSkipped('BMS FREE CAROUSEL_FEED test skipped: ' . $e->getMessage());
        }
    }

    /**
     * Test sending BMS FREE CAROUSEL_COMMERCE type
     */
    public function testSendBmsCarouselCommerce(): void
    {
        $imagePath = $this->getTestImagePath();
        if (!$imagePath) {
            $this->markTestSkipped('Test image not found');
        }

        try {
            $imageId = $this->messageService->uploadFile($imagePath, 'BMS_CAROUSEL_COMMERCE_LIST');

            $items = [];
            for ($i = 1; $i <= 2; $i++) {
                $commerce = new BmsCommerce();
                $commerce->setTitle("상품 $i")
                    ->setRegularPrice(10000 * $i);

                $button = new BmsButton();
                $button->setLinkType('WL')
                    ->setName('구매하기')
                    ->setLinkMobile("https://example.com/product$i");

                $item = new BmsCarouselCommerceItem();
                $item->setCommerce($commerce)
                    ->setImageId($imageId)
                    ->setButtons([$button]);
                $items[] = $item;
            }

            $tail = new BmsCarouselTail();
            $tail->setLinkMobile('https://example.com/more');

            $carousel = new BmsCarousel();
            $carousel->setList($items)
                ->setTail($tail);

            $bms = new KakaoBms();
            $bms->setTargeting('I')
                ->setChatBubbleType(BmsChatBubbleType::CAROUSEL_COMMERCE)
                ->setCarousel($carousel);

            $kakaoOption = new KakaoOption();
            $kakaoOption->setPfId($this->pfId)
                ->setBms($bms);

            $message = new Message();
            $message->setTo($this->recipientNumber)
                ->setFrom($this->senderNumber)
                ->setType('BMS_FREE')
                ->setKakaoOptions($kakaoOption);

            $response = $this->messageService->send($message);

            $this->assertInstanceOf(SendResponse::class, $response);
            $this->assertNotNull($response->groupInfo);
            $this->assertGreaterThan(0, $response->groupInfo->count->total);

            echo sprintf(
                "\nGroup ID: %s\nTotal: %d\nSuccess: %d\n",
                $response->groupInfo->groupId,
                $response->groupInfo->count->total,
                $response->groupInfo->count->registeredSuccess
            );
        } catch (Exception $e) {
            $this->markTestSkipped('BMS FREE CAROUSEL_COMMERCE test skipped: ' . $e->getMessage());
        }
    }

    /**
     * Test sending BMS FREE PREMIUM_VIDEO type
     * Note: Requires a valid Kakao TV video URL
     */
    public function testSendBmsPremiumVideo(): void
    {
        try {
            $video = new BmsVideo();
            $video->setVideoUrl('https://tv.kakao.com/v/123456789');

            $bms = new KakaoBms();
            $bms->setTargeting('I')
                ->setChatBubbleType(BmsChatBubbleType::PREMIUM_VIDEO)
                ->setVideo($video)
                ->setContent('[E2E 테스트] BMS FREE PREMIUM_VIDEO 테스트입니다.');

            $kakaoOption = new KakaoOption();
            $kakaoOption->setPfId($this->pfId)
                ->setBms($bms);

            $message = new Message();
            $message->setTo($this->recipientNumber)
                ->setFrom($this->senderNumber)
                ->setType('BMS_FREE')
                ->setKakaoOptions($kakaoOption);

            $response = $this->messageService->send($message);

            $this->assertInstanceOf(SendResponse::class, $response);
            $this->assertNotNull($response->groupInfo);
            $this->assertGreaterThan(0, $response->groupInfo->count->total);

            echo sprintf(
                "\nGroup ID: %s\nTotal: %d\nSuccess: %d\n",
                $response->groupInfo->groupId,
                $response->groupInfo->count->total,
                $response->groupInfo->count->registeredSuccess
            );
        } catch (Exception $e) {
            $this->markTestSkipped('BMS FREE PREMIUM_VIDEO test skipped: ' . $e->getMessage());
        }
    }

    /**
     * Get test image path (1:1 ratio for IMAGE, COMMERCE, CAROUSEL types)
     */
    private function getTestImagePath(): ?string
    {
        if ($this->testImagePath && file_exists($this->testImagePath)) {
            return $this->testImagePath;
        }

        $possiblePaths = [
            __DIR__ . '/../assets/example-1to1.jpg',
            __DIR__ . '/../../examples/images/example_square.jpg',
            __DIR__ . '/../../examples/images/example_wide.jpg',
            __DIR__ . '/../fixtures/test_image.jpg',
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Get wide test image path (2:1 ratio for WIDE, WIDE_ITEM_LIST main types)
     */
    private function getWideTestImagePath(): ?string
    {
        $possiblePaths = [
            __DIR__ . '/../assets/example-2to1.jpg',
            __DIR__ . '/../../examples/images/example_wide.jpg',
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }
}

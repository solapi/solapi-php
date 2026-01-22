<?php

/**
 * BMS 자유형 COMMERCE 타입 발송 예제
 * 상품 정보와 가격을 포함한 커머스 메시지입니다.
 * imageId, commerce, buttons가 필수입니다.
 *
 * 가격 조합 규칙:
 * 1. regularPrice만 사용 (정가만 표기)
 * 2. regularPrice + discountPrice + discountRate (할인율 표기)
 * 3. regularPrice + discountPrice + discountFixed (정액 할인 표기)
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Nurigo\Solapi\Models\Kakao\Bms\BmsButton;
use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCommerce;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCoupon;
use Nurigo\Solapi\Models\Kakao\KakaoBms;
use Nurigo\Solapi\Models\Kakao\KakaoOption;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Services\SolapiMessageService;

$messageService = new SolapiMessageService('ENTER_YOUR_API_KEY', 'ENTER_YOUR_API_SECRET');

$imageId = $messageService->uploadFile(__DIR__ . '/images/product.jpg', 'BMS');

$commerce = new BmsCommerce();
$commerce->setTitle('프리미엄 블루투스 스피커')
    ->setRegularPrice(129000)
    ->setDiscountPrice(99000)
    ->setDiscountRate(23);

$buyButton = new BmsButton();
$buyButton->setLinkType('WL')
    ->setName('지금 구매하기')
    ->setLinkMobile('https://example.com/buy');

$coupon = new BmsCoupon();
$coupon->setTitle('10000원 할인 쿠폰')
    ->setDescription('첫 구매 고객 전용 쿠폰입니다.')
    ->setLinkMobile('https://example.com/coupon');

$bms = new KakaoBms();
$bms->setTargeting('I')
    ->setChatBubbleType(BmsChatBubbleType::COMMERCE)
    ->setImageId($imageId)
    ->setCommerce($commerce)
    ->setButtons([$buyButton])
    ->setCoupon($coupon)
    ->setAdditionalContent('무료배송 | 오늘 주문 시 내일 도착');

$kakaoOption = new KakaoOption();
$kakaoOption->setPfId('연동한 비즈니스 채널의 pfId')
    ->setBms($bms);

$message = new Message();
$message->setTo('수신번호')
    ->setFrom('발신번호')
    ->setType('BMS_FREE')
    ->setKakaoOptions($kakaoOption);

try {
    $response = $messageService->send($message);
    print_r($response);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

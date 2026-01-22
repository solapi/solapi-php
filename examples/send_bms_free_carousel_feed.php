<?php

/**
 * BMS 자유형 CAROUSEL_FEED 타입 발송 예제
 * 여러 카드를 좌우로 슬라이드하는 캐러셀 피드 메시지입니다.
 * fileType은 'BMS_CAROUSEL_FEED_LIST'를 사용해야 합니다 (2:1 비율 이미지 필수).
 * head 없이 2-6개 아이템, head 포함 시 1-5개 아이템이 가능합니다.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Nurigo\Solapi\Models\Kakao\Bms\BmsButton;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarousel;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarouselFeedItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCarouselTail;
use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\KakaoBms;
use Nurigo\Solapi\Models\Kakao\KakaoOption;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Services\SolapiMessageService;

$messageService = new SolapiMessageService('ENTER_YOUR_API_KEY', 'ENTER_YOUR_API_SECRET');

$imageId = $messageService->uploadFile(__DIR__ . '/images/example-2to1.jpg', 'BMS_CAROUSEL_FEED_LIST');

$button1 = new BmsButton();
$button1->setLinkType('WL')
    ->setName('레시피 보기')
    ->setLinkMobile('https://example.com/recipe1');

$item1 = new BmsCarouselFeedItem();
$item1->setHeader('오늘의 브런치 레시피')
    ->setContent('15분 만에 완성하는 아보카도 토스트! 간단하지만 영양 만점이에요.')
    ->setImageId($imageId)
    ->setButtons([$button1]);

$button2 = new BmsButton();
$button2->setLinkType('WL')
    ->setName('영상 보기')
    ->setLinkMobile('https://example.com/recipe2');

$item2 = new BmsCarouselFeedItem();
$item2->setHeader('홈카페 꿀팁')
    ->setContent('집에서 바리스타처럼! 라떼 아트 도전해보세요.')
    ->setImageId($imageId)
    ->setButtons([$button2]);

$tail = new BmsCarouselTail();
$tail->setLinkMobile('https://example.com/more');

$carousel = new BmsCarousel();
$carousel->setList([$item1, $item2])
    ->setTail($tail);

$bms = new KakaoBms();
$bms->setTargeting('I')
    ->setChatBubbleType(BmsChatBubbleType::CAROUSEL_FEED)
    ->setCarousel($carousel);

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

<?php

/**
 * BMS 자유형 WIDE_ITEM_LIST 타입 발송 예제
 * 와이드 아이템 리스트 형식으로, 메인 아이템 + 서브 아이템(최소 3개) 구조입니다.
 * header, mainWideItem, subWideItemList가 필수입니다.
 *
 * 이미지 fileType:
 * - mainWideItem: 'BMS_WIDE_MAIN_ITEM_LIST' (2:1 비율)
 * - subWideItemList: 'BMS_WIDE_SUB_ITEM_LIST' (1:1 비율)
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\Bms\BmsMainWideItem;
use Nurigo\Solapi\Models\Kakao\Bms\BmsSubWideItem;
use Nurigo\Solapi\Models\Kakao\KakaoBms;
use Nurigo\Solapi\Models\Kakao\KakaoOption;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Services\SolapiMessageService;

$messageService = new SolapiMessageService('ENTER_YOUR_API_KEY', 'ENTER_YOUR_API_SECRET');

$mainImageId = $messageService->uploadFile(__DIR__ . '/images/example-2to1.jpg', 'BMS_WIDE_MAIN_ITEM_LIST');
$subImageId = $messageService->uploadFile(__DIR__ . '/images/example-1to1.jpg', 'BMS_WIDE_SUB_ITEM_LIST');

$mainItem = new BmsMainWideItem();
$mainItem->setTitle('이번 주 베스트셀러')
    ->setImageId($mainImageId)
    ->setLinkMobile('https://example.com/bestseller');

$subItem1 = new BmsSubWideItem();
$subItem1->setTitle('프리미엄 헤드폰')
    ->setImageId($subImageId)
    ->setLinkMobile('https://example.com/item1');

$subItem2 = new BmsSubWideItem();
$subItem2->setTitle('무선 이어폰')
    ->setImageId($subImageId)
    ->setLinkMobile('https://example.com/item2');

$subItem3 = new BmsSubWideItem();
$subItem3->setTitle('블루투스 스피커')
    ->setImageId($subImageId)
    ->setLinkMobile('https://example.com/item3');

$bms = new KakaoBms();
$bms->setTargeting('I')
    ->setChatBubbleType(BmsChatBubbleType::WIDE_ITEM_LIST)
    ->setHeader('홍길동님을 위한 추천 상품')
    ->setMainWideItem($mainItem)
    ->setSubWideItemList([$subItem1, $subItem2, $subItem3]);

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

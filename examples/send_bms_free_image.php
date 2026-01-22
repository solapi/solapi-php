<?php

/**
 * BMS 자유형 IMAGE 타입 발송 예제
 * 이미지를 포함한 메시지로, fileType은 'BMS'를 사용해야 합니다.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Nurigo\Solapi\Models\Kakao\Bms\BmsButton;
use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\KakaoBms;
use Nurigo\Solapi\Models\Kakao\KakaoOption;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Services\SolapiMessageService;

$messageService = new SolapiMessageService('ENTER_YOUR_API_KEY', 'ENTER_YOUR_API_SECRET');

$imageId = $messageService->uploadFile(__DIR__ . '/images/example.jpg', 'BMS');

$button = new BmsButton();
$button->setLinkType('WL')
    ->setName('자세히 보기')
    ->setLinkMobile('https://example.com');

$bms = new KakaoBms();
$bms->setTargeting('I')
    ->setChatBubbleType(BmsChatBubbleType::IMAGE)
    ->setImageId($imageId)
    ->setButtons([$button]);

$kakaoOption = new KakaoOption();
$kakaoOption->setPfId('연동한 비즈니스 채널의 pfId')
    ->setBms($bms);

$message = new Message();
$message->setTo('수신번호')
    ->setFrom('발신번호')
    ->setText('이미지와 함께하는 BMS 자유형 메시지입니다.')
    ->setType('BMS_FREE')
    ->setKakaoOptions($kakaoOption);

try {
    $response = $messageService->send($message);
    print_r($response);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

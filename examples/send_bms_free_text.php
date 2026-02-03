<?php

/**
 * BMS 자유형 TEXT 타입 발송 예제
 * 텍스트 전용 메시지로, 버튼과 쿠폰을 포함할 수 있습니다.
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Nurigo\Solapi\Models\Kakao\Bms\BmsButton;
use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCoupon;
use Nurigo\Solapi\Models\Kakao\KakaoBms;
use Nurigo\Solapi\Models\Kakao\KakaoOption;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Services\SolapiMessageService;

$messageService = new SolapiMessageService('ENTER_YOUR_API_KEY', 'ENTER_YOUR_API_SECRET');

$bms = new KakaoBms();
$bms->setTargeting('I')
    ->setChatBubbleType(BmsChatBubbleType::TEXT);

$kakaoOption = new KakaoOption();
$kakaoOption->setPfId('연동한 비즈니스 채널의 pfId')
    ->setBms($bms);

$message = new Message();
$message->setTo('수신번호')
    ->setFrom('발신번호')
    ->setText('안녕하세요! BMS 자유형 TEXT 메시지입니다.')
    ->setType('BMS_FREE')
    ->setKakaoOptions($kakaoOption);

try {
    $response = $messageService->send($message);
    print_r($response);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

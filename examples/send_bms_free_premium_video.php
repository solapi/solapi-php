<?php

/**
 * BMS 자유형 PREMIUM_VIDEO 타입 발송 예제
 * 카카오TV 동영상을 포함한 프리미엄 비디오 메시지입니다.
 * videoUrl은 반드시 "https://tv.kakao.com/"으로 시작해야 합니다.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Nurigo\Solapi\Models\Kakao\Bms\BmsButton;
use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\Bms\BmsCoupon;
use Nurigo\Solapi\Models\Kakao\Bms\BmsVideo;
use Nurigo\Solapi\Models\Kakao\KakaoBms;
use Nurigo\Solapi\Models\Kakao\KakaoOption;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Services\SolapiMessageService;

$messageService = new SolapiMessageService('ENTER_YOUR_API_KEY', 'ENTER_YOUR_API_SECRET');

$video = new BmsVideo();
$video->setVideoUrl('https://tv.kakao.com/v/460734285');

$button = new BmsButton();
$button->setLinkType('WL')
    ->setName('더 많은 영상 보기')
    ->setLinkMobile('https://example.com/videos');

$coupon = new BmsCoupon();
$coupon->setTitle('10% 할인 쿠폰')
    ->setDescription('영화 예매 시 사용 가능한 할인 쿠폰입니다.')
    ->setLinkMobile('https://example.com/coupon');

$bms = new KakaoBms();
$bms->setTargeting('I')
    ->setChatBubbleType(BmsChatBubbleType::PREMIUM_VIDEO)
    ->setHeader('이 주의 추천 영화')
    ->setContent('2024년 최고의 액션 블록버스터! 지금 바로 예고편을 확인해보세요.')
    ->setVideo($video)
    ->setButtons([$button])
    ->setCoupon($coupon);

$kakaoOption = new KakaoOption();
$kakaoOption->setPfId('연동한 비즈니스 채널의 pfId')
    ->setBms($bms);

$message = new Message();
$message->setTo('수신번호')
    ->setFrom('발신번호')
    ->setText('주말 영화 추천!\n\n올해 가장 화제가 된 영화를 미리 만나보세요.')
    ->setType('BMS_FREE')
    ->setKakaoOptions($kakaoOption);

try {
    $response = $messageService->send($message);
    print_r($response);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

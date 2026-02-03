<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Nurigo\Solapi\Exceptions\MessageNotReceivedException;
use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Models\Voice\VoiceOption;
use Nurigo\Solapi\Models\Voice\VoiceReplyRange;
use Nurigo\Solapi\Models\Voice\VoiceType;
use Nurigo\Solapi\Services\SolapiMessageService;

/**
 * 음성 메시지 발송 예제, 음성 메시지에 대한 설명은 아래 링크를 참고해주세요!
 * @see https://developers.solapi.com/references/voice
 * 발신번호, 수신번호, 고객센터 연결번호에 반드시 -, * 등 특수문자를 제거하여 기입하셔야 합니다! 예) 01012345678
 */
try {
    $messageService = new SolapiMessageService("ENTER_YOUR_API_KEY", "ENTER_YOUR_API_SECRET");

    $voiceOption = new VoiceOption();
    // tailMessage를 사용한다면 반드시 headerMessage도 설정해주세요.
    $voiceOption->setVoiceType(VoiceType::FEMALE)
        ->setHeaderMessage("머릿말입니다.")
        ->setTailMessage("꼬릿말입니다.");

    // $voiceOption에서 replyRange와 counselorNumber는 같이 사용할 수 없습니다! 둘중 하나의 옵션만 선택해서 발송해주세요.

    // replyRange는 1~9까지 허용됩니다. VoiceReplyRange 내 상수 값으로 접근해주세요!
    // $voiceOption->setReplyRange(VoiceReplyRange::NINE);

    // 고객센터 번호를 설정할 경우 사용자가 다이얼 0번을 눌러야 입력한 고객센터 번호로 이동합니다.
    // $voiceOption->setCounselorNumber("연결할 고객센터 번호");


    $message = new Message();
    $message->setTo("수신번호")
        ->setFrom("계정에서 등록한 발신번호 입력")
        ->setText("음성 메시지 입니다. 최대 1, 최대 980byte(한글 490자)까지 입력 가능합니다.")
        ->setVoiceOptions($voiceOption);

    // 예약 발송을 원하시는 경우 아래 주석을 해제하고 응용하여 사용해보세요!
    // date_default_timezone_set("Asia/Seoul");
    // $dateTime = DateTime::createFromFormat("Y-m-d H:i:s", "2022-11-03 18:00:00");
    // $result = $messageService->send($message, $dateTime);

    $result = $messageService->send($message);
    print_r($result);
} catch (MessageNotReceivedException $exception) {
    print_r($exception->getFailedMessageList());
    print_r("----");
    print_r($exception->getMessage());
} catch (Exception $exception) {
    print_r($exception->getMessage());
}
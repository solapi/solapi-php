<?php
require_once("../../lib/message.php");

// 예약발송 설정
try {
    $result = set_reservation_group_messages(
        array(
            array(
                "to" => "01000010001",
                "from" => "029302266",
                "text" => "한글 45자, 영자 90자 이하 입력되면 자동으로 SMS타입의 메시지가 추가됩니다."
            ),
            array(
                "to" => "01000010002",
                "from" => "029302266",
                "text" => "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시자가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
            ),
            // 타입을 명시할 경우 text 길이가 한글 45 혹은 영자 90자를 넘을 경우 오류가 발생합니다.
            array(
                "type" => "SMS", // 타입명시
                "to" => "01000010003",
                "from" => "029302266",
                "text" => "SMS 타입에 한글 45자, 영자 90자 이상 입력되면 오류가 발생합니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
            ),
            array(
                "to" => "01000010004",
                "from" => "029302266",
                "text" => "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시지가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
            ),
            array(
                "to" => "01000010005",
                "from" => "029302266",
                "subject" => "LMS 제목", // 제목을 지정할 수 있습니다.
                "text" => "내용이 짧아도 LMS로 발송됩니다."
            ),
            array(
                "type" => "LMS", // 타입을 명시할 수 있습니다.
                "to" => "01000010006",
                "from" => "029302266",
                "text" => "내용이 짧아도 LMS로 발송됩니다."
            ),
            array(
                "to" => array("01000010008", "01000010009"), // 수신번호를 array로 입력하면 같은 내용을 여러명에게 보낼 수 있습니다.
                "from" => "029302266",
                "text" => "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시지가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
            )
        ),
        // 예약발송 할 날짜 설정, 반드시 현재 시각보다 더 나중의 시간을 입력해야 합니다.
        '2022-02-09 17:36:00'
    );
    print_r($result);

    // 예약 발송 건을 취소하고 싶으실 경우 아래 코드를 추가해보세요.
    // cancel_reserved_group($result->groupId);
} catch (\Exception $exception) {
    error_log('예약 발송 설정 실패');
    error_log('------');
    error_log($exception->getMessage());
    error_log('------');
}
<?php
/*
 * LMS 발송 예제
 * subject 입력이 없는 경우 자동으로 내용 앞 부분을 LMS 제목으로 사용합니다.
 */
require_once("../../lib/message.php");
$messages = array(
    array(
        "to" => "01000010001",
        "from" => "029302266",
        "text" => "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시자가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    ),
    array(
        "to" => "01000010002",
        "from" => "029302266",
        "subject" => "LMS 제목", // 제목을 지정할 수 있습니다.
        "text" => "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시자가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    ),
    array(
        "type" => "LMS", // 타입을 명시할 수 있습니다.
        "to" => "01000010003",
        "from" => "029302266",
        "text" => "내용이 짧아도 LMS로 발송됩니다."
    ),
    array(
        "to" => "01000010004",
        "from" => "029302266",
        "text" => "한글 45자, 영자 90자 이하는 자동으로 SMS타입의 문자가 발송됩니다."
    ),
    array(
        "to" => array("01000010005", "01000010006"), // 수신번호를 array로 입력하면 같은 내용을 여러명에게 보낼 수 있습니다.
        "from" => "029302266",
        "text" => "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시자가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    ),
);
print_r(send_messages($messages));

<?php
/*
 * Auto Type Detect는 기본값으로 활성화(true)되어 있습니다.
 */
require_once("../../lib/message.php");
$messages = array(
    array(
        "autoTypeDetect" => true,
        "to" => "01000010001",
        "from" => "029302266",
        "text" => "한글 45자, 영자 90자 이하 입력되면 자동으로 SMS타입의 메시지가 추가됩니다."
    ),
    // autoTypeDetect가 비활성화되면 한글 45자, 영자 90자 이하로 입력하더라도 자동으로 타입을 지정해주지 않으므로 타입을 명시해야 합니다.
    array(
        "autoTypeDetect" => false,
        "to" => "01000010002",
        "from" => "029302266",
        "text" => "한글 45자, 영자 90자 이하 입력"
    ),
    // autoTypeDetect가 비활성화되면 한글 45자, 영자 90자 이하로 입력하더라도 자동으로 타입을 지정해주지 않으므로 타입을 명시해야 합니다.
    array(
        "autoTypeDetect" => false,
        "type" => "SMS",
        "to" => "01000010003",
        "from" => "029302266",
        "text" => "한글 45자, 영자 90자 이하 입력"
    )
);
print_r(send_messages($messages));

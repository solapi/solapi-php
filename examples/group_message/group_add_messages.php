<?php
/*
  그룹메시지 추가 예제 
*/
require_once("../../lib/message.php");

// 그룹생성
$groupId = create_group();

// 발송할 이미지를 먼저 업로드합니다.
$imageId = create_image(realpath("./testImage.jpg"));

// 메시지 추가
print_r(add_messages($groupId, array(
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
        "text" => "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시지가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    ),
    array(
        "type" => "LMS", // 타입을 명시할 수 있습니다.
        "to" => "01000010006",
        "from" => "029302266",
        "text" => "내용이 짧아도 LMS로 발송됩니다."
    ),
    array(
        "to" => "01000010007",
        "from" => "029302266",
        "subject" => "MMS 제목",
        "text" => "MMS 이미지 발송",
        "imageId" => $imageId
    ),
    array(
        "to" => array("01000010008", "01000010009"), // 수신번호를 array로 입력하면 같은 내용을 여러명에게 보낼 수 있습니다.
        "from" => "029302266",
        "text" => "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시지가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    )
)));

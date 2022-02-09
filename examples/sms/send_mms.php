<?php
/*
 * 한번의 요청으로 1만건까지 MMS 이미지 발송이 가능합니다.
 */
require_once("../../lib/message.php");

// 발송할 이미지를 먼저 업로드합니다.
$imageId = create_image(realpath("../testImage.jpg"));

$messages = array(
    array(
        "to" => "01000010001",
        "from" => "029302266",
        "subject" => "MMS 제목",
        "imageId" => $imageId,
        "text" => "이미지 아이디가 입력되면 MMS로 발송됩니다."
    ),
    array(
        "to" => "01000010002",
        "from" => "029302266",
        "subject" => "MMS 제목",
        "imageId" => $imageId,
        "text" => "동일한 이미지 아이디가 입력되면 동일한 이미지가 MMS로 발송됩니다."
    ),
    array(
        "to" => array("01000010003", "01000010004"), // array로 입력하면 여러명에게 동일한 내용으로 발송됩니다.
        "from" => "029302266",
        "subject" => "MMS 제목",
        "imageId" => $imageId,
        "text" => "동일한 이미지 아이디가 입력되면 동일한 이미지가 MMS로 발송됩니다."
    )
);
print_r(send_messages($messages));

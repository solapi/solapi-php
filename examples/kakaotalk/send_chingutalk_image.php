<?php
/*
 * 친구톡 보내기
 * 카카오톡채널 친구로 추가되어 있어야 친구톡 발송이 가능합니다.
 * 템플릿 등록없이 버튼을 포함하여 자유롭게 메시지 전송이 가능합니다. 
 */
require_once("../../lib/message.php");

// 친구톡 이미지 업로드
$imageId = create_kakao_image(realpath("../testImage.jpg"), "https://example.com");

$messages = array(
    array(
        "to" => "01000010001",
        "from" => "029302266",
        "text" => "카카오톡채널 친구로 추가되어 있어야 친구톡 발송이 가능합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "imageId" => $imageId
        )
    ),
    array(
        "to" => "01000010002",
        "from" => "029302266",
        "text" => "카카오톡채널 친구로 추가되어 있어야 친구톡 발송이 가능합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "imageId" => $imageId
        )
    ),
    array(
        "to" => array("01000010003", "01000010004"), // array 사용으로 동일한 내용을 여러 수신번호에 전송 가능
        "from" => "029302266",
        "text" => "카카오톡채널 친구로 추가되어 있어야 친구톡 발송이 가능합니다.",
        "kakaoOptions" => array(
            "pfId" => "KA01PF200323182344986oTFz9CIabcx",
            "imageId" => $imageId
        )
    )
    // 계속해서 1만건 추가 가능.
);
print_r(send_messages($messages));

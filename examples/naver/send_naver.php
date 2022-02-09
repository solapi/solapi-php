<?php
/*
 * 한번 요청으로 1만건의 네이버 톡톡(네이버 스마트 알림) 발송이 가능합니다.
 * 등록되어 있는 템플릿의 변수 부분을 제외한 나머지 부분(상수)은 100% 일치해야 합니다.
 * 템플릿 내용이 "#{이름}님 가입을 환영합니다."으로 등록되어 있는 경우 변수 #{이름}을 홍길동으로 치환하여 "홍길동님 가입을 환영합니다."로 입력해 주세요.
 */
require_once("../../lib/message.php");
$messages = array(
    array(
        "type" => "NSA",
        "to" => "01000000001",
        "from" => "029302266",
        "text" => "홍길동님 가입을 환영합니다.",
        "naverOptions" => array(
            "talkId" => "NA01TK210309221311111uPDDRgz4dG2",
            "templateId" => "NA01TP2104050534081111ins9Kzo131"
        )
    ),
    // 버튼 예제
    array(
        "type" => "NSA",
        "to" => "01000000001",
        "from" => "029302266",
        "text" => "홍길동님 가입을 환영합니다.",
        "naverOptions" => array(
            "talkId" => "NA01TK210309221311111uPDDRgz4dG2",
            "templateId" => "NA01TP2104050534081111ins9Kzo132",
            "buttons" => array(
                array(
                    "buttonType" => "WL",
                    "buttonCode" => "btn1", // 버튼 코드를 입력하세요. (템플릿 상세보기에서 확인 가능)
                    "linkMo" => "https://www.example.com/", // URL은 자유롭게 입력 가능
                    "linkPc" => "https://www.example.com/" // URL은 자유롭게 입력 가능
                )
            )
        )
    ),
    // 계속해서 1만건 추가 가능.
);
print_r(send_messages($messages));

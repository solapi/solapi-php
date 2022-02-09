<?php
/*
 * RCS LMS 메시지 1만건을 한번의 요청으로 발송할 수 있습니다.
 */
require_once('../../lib/message.php');
$messages = array(
    array(
        'to' => '01000000001',
        'from' => '029302266',
        'type' => 'RCS_LMS',
        'subject' => 'LMS 제목',
        'text' => 'RCS LMS를 발송합니다.',
        'rcsOptions' => array(
            'brandId' => 'RC01BR210526093952685ArBrUMyeOTy', // RCSBizCenter(https://www.rcsbizcenter.com/)에서 발급받은 브랜드ID 입력
        )
    ),
    // 버튼이 포함된 RCS LMS를 발송합니다. 버튼은 최대 3개까지 추가 가능합니다.
    array(
        'to' => '01000000001',
        'from' => '029302266',
        'type' => 'RCS_LMS',
        'subject' => 'LMS 제목',
        'text' => '버튼이 포함된 RCS LMS를 발송합니다. 버튼은 최대 3개까지 추가 가능합니다.',
        'rcsOptions' => array(
            'brandId' => 'RC01BR210526093952685ArBrUMyeOTy',
            'buttons' => array(
                array('buttonType' => 'WL', 'buttonName' => '홈페이지 바로가기', 'link' => 'https://nurigo.net')
                // , array( 'buttonType' => 'ML', 'buttonName' => '지도 위치 표시', 'latitude' => '37.280342669603684', 'longitude' => '127.11824209721874', 'label' => '누리고', 'link' => 'https://nurigo.net')
                // , array( 'buttonType' => 'MQ', 'buttonName' => '지도 검색', 'link' => 'https://nurigo.net', 'query' => '(주)누리고' )
                // , array( 'buttonType' => 'MR', 'buttonName' => '나의 현재 위치' )
                // , array( 'buttonType' => 'CA', 'buttonName' => '캘린더 일정 생성', 'title' => '제목', 'startTime' => '2021-06-19T00:00:00.000Z', 'endTime' => '2021-06-19T09:00:00.000Z', 'text' => '메모' )
                // , array( 'buttonType' => 'CL', 'buttonName' => '텍스트 복사', 'text' => '복사할 텍스트 내용' )
                // , array( 'buttonType' => 'DL', 'buttonName' => '전화 걸기', 'phone' => '01012345678' )
                // , array( 'buttonType' => 'MS', 'buttonName' => '메시지 보내기', 'phone' => '01012345678', 'text' => '보낼 메시지 내용' )
            )
        )
    )
    // ...
    // 1만개 추가 가능
);
print_r(send_messages($messages));

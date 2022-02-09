<?php
/*
 * RCS MMS 메시지 1만건을 한번의 요청으로 발송할 수 있습니다.
 */
require_once('../../lib/message.php');

$sample1 = create_rcs_image(realpath("./images/sample1.png"));
$sample2 = create_rcs_image(realpath("./images/sample2.png"));
$sample3 = create_rcs_image(realpath("./images/sample3.png"));
$sample4 = create_rcs_image(realpath("./images/sample4.png"));
$sample5 = create_rcs_image(realpath("./images/sample5.png"));
$sample6 = create_rcs_image(realpath("./images/sample6.png"));

$messages = array(
    // 버튼이 포함된 RCS MMS를 발송합니다. 버튼은 최대 3개까지 추가 가능합니다.
    array(
        'to' => '01000000001',
        'from' => '029302266',
        'type' => 'RCS_MMS',
        'subject' => 'Sample1',
        'text' => '버튼이 포함된 RCS MMS를 발송합니다.',
        'imageId' => $sample1,
        'rcsOptions' => array(
            'mmsType' => 'S6', // ~ S6 (총 이미지 1M를 넘을 수 없음)
            'brandId' => 'RC01BR210526093952685ArBrUMyeOTy',
            'buttons' => array(
                array('buttonType' => 'WL', 'buttonName' => '버튼 1', 'link' => 'https://nurigo.net')
            , array('buttonType' => 'WL', 'buttonName' => '버튼 2', 'link' => 'https://nurigo.net')
                // , array( 'buttonType' => 'ML', 'buttonName' => '지도 위치 표시', 'latitude' => '37.280342669603684', 'longitude' => '127.11824209721874', 'label' => '누리고', 'link' => 'https://nurigo.net')
                // , array( 'buttonType' => 'MQ', 'buttonName' => '지도 검색', 'link' => 'https://nurigo.net', 'query' => '(주)누리고' )
                // , array( 'buttonType' => 'MR', 'buttonName' => '나의 현재 위치' )
                // , array( 'buttonType' => 'CA', 'buttonName' => '캘린더 일정 생성', 'title' => '제목', 'startTime' => '2021-06-19T00:00:00.000Z', 'endTime' => '2021-06-19T09:00:00.000Z', 'text' => '메모' )
                // , array( 'buttonType' => 'CL', 'buttonName' => '텍스트 복사', 'text' => '복사할 텍스트 내용' )
                // , array( 'buttonType' => 'DL', 'buttonName' => '전화 걸기', 'phone' => '01012345678' )
                // , array( 'buttonType' => 'MS', 'buttonName' => '메시지 보내기', 'phone' => '01012345678', 'text' => '보낼 메시지 내용' )
            ),
            'additionalBody' => array(
                array(
                    'imageId' => $sample2,
                    'title' => 'Sample 2',
                    'description' => 'Description 설명', // 총합 1,300자
                    'buttons' => array(array('buttonType' => 'WL', 'buttonName' => '버튼 1', 'link' => 'https://solapi.com'), array('buttonType' => 'WL', 'buttonName' => '버튼 2', 'link' => 'https://solapi.com'))
                ), array(
                    'imageId' => $sample3,
                    'title' => 'Sample 3',
                    'description' => 'Description 설명', // 총합 1,300자
                    'buttons' => array(array('buttonType' => 'WL', 'buttonName' => '버튼 1', 'link' => 'https://solapi.com'), array('buttonType' => 'WL', 'buttonName' => '버튼 2', 'link' => 'https://solapi.com'))
                ), array(
                    'imageId' => $sample4,
                    'title' => 'Sample 4',
                    'description' => 'Description 설명', // 총합 1,300자
                    'buttons' => array(array('buttonType' => 'WL', 'buttonName' => '버튼 1', 'link' => 'https://solapi.com'), array('buttonType' => 'WL', 'buttonName' => '버튼 2', 'link' => 'https://solapi.com'))
                ), array(
                    'imageId' => $sample5,
                    'title' => 'Sample 5',
                    'description' => 'Description 설명', // 총합 1,300자
                    'buttons' => array(array('buttonType' => 'WL', 'buttonName' => '버튼 1', 'link' => 'https://solapi.com'), array('buttonType' => 'WL', 'buttonName' => '버튼 2', 'link' => 'https://solapi.com'))
                ), array(
                    'imageId' => $sample6,
                    'title' => 'Sample 6',
                    'description' => 'Description 설명', // 총합 1,300자
                    'buttons' => array(array('buttonType' => 'WL', 'buttonName' => '버튼 1', 'link' => 'https://solapi.com'), array('buttonType' => 'WL', 'buttonName' => '버튼 2', 'link' => 'https://solapi.com'))
                )
            )
        )
    )
    // ...
    // 1만개 추가 가능
);
print_r(send_messages($messages));

<?php
require_once("../../lib/message.php");

// 예약발송 설정 예제
// STEP 1 그룹 생성
$groupId = create_group();
print_r($groupId);

// STEP 2 예약 설정, 메시지 추가 코드 생략
// 그룹 내 메시지 추가는 group_add_messages.php 파일을 참고하세요.
// 예약 날짜의 경우 반드시 현재 시각보다 더 나중의 시간을 입력해야 합니다.
$result = reserve_group($groupId, "2022-02-09 00:00:00");
print_r($result);

// 예약 발송 건을 취소하고 싶으실 경우 아래 코드를 추가해보세요.
// cancel_reserved_group($groupId);
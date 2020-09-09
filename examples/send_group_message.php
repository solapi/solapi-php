<?php
/*
 그룹메시지 발송
*/
require_once("../lib/message.php");
$groupId = create_group();
// 1개 추가
add_message($groupId, "01000000001", "029302266", "테스트 메시지");
// 2개 추가 (한번 호출에 최대 1만건 추가 가능)
add_message($groupId, ["01000000002", "01000000003"], "029302266", "테스트 메시지");
print_r(send_message($groupId));

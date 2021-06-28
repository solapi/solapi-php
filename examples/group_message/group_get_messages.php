<?php
/*
 그룹 메시지 목록 조회
*/
require_once("../../lib/message.php");

$groupId = create_group();
add_message($groupId, "01000000001", "01000000002", "테스트 메시지");
print_r(get_group_messages($groupId));

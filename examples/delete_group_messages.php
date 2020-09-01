<?php
/*
 그룹 메시지 삭제
*/
require_once("../lib/message.php");

$groupId = create_group();
$result = add_message($groupId, "01000000001", "01000000002", "테스트 메시지");
print_r(delete_messages($groupId, $reult->resultList[0]->messageId));

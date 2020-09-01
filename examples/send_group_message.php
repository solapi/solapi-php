<?php
/*
 그룹메시지 발송
*/
require_once("../lib/message.php");
$groupId = create_group();
add_message($groupId, "01000000001", "029302266", "테스트 메시지");
print_r(send_message($groupId));

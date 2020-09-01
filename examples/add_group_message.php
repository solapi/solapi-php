<?php
/*
  그룹메시지 추가 예제 
*/
require_once("../lib/message.php");
$groupId = create_group();
print_r(add_message($groupId, "01000010002", "029302266", "한글 45자, 영자 90자 이하 입력되면 자동으로 SMS타입의 메시자가 추가됩니다."));

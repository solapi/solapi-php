<?php
/*
 그룹 메시지 삭제
*/
require_once("../../lib/message.php");

$groupId = create_group();
$result = add_messages($groupId, array(
    array(
        "to" => "01000010001",
        "from" => "029302266",
        "text" => "한글 45자, 영자 90자 이하 입력되면 자동으로 SMS타입의 메시지가 추가됩니다."
    ),
    array(
        "to" => "01000010002",
        "from" => "029302266",
        "text" => "한글 45자, 영자 90자 이상 입력되면 자동으로 LMS타입의 문자메시자가 발송됩니다. 0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    )
));
print_r(delete_messages($groupId, $result->resultList[0]->messageId));

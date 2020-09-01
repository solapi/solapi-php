<?php
/*
 그룹 정보 조회
*/
require_once("../lib/message.php");
$gorup_info = create_group();
print_r(get_group_info($group_info->groupId));

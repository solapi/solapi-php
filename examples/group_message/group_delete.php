<?php
/*
 그룹 삭제 
*/
require_once("../../lib/message.php");
$groupId = create_group();
print_r(delete_group($groupId));

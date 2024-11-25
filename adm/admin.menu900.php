<?php
if($member[mb_id] == "admin"){
    $menu["menu900"] = array (
        array('900000', 'SMS 관리', ''.G5_SMS5_ADMIN_URL.'/config.php', 'sms5'),
        array('900100', 'SMS 기본설정', ''.G5_SMS5_ADMIN_URL.'/config.php', 'sms5_config'),
        array('900200', '회원정보업데이트', ''.G5_SMS5_ADMIN_URL.'/member_update.php', 'sms5_mb_update'),
    );
}

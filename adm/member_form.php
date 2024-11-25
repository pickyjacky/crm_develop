<?php
$sub_menu = "200100";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$mb = array(
'mb_certify' => null,
'mb_adult' => null,
'mb_sms' => null,
'mb_intercept_date' => null,
'mb_id' => null,
'mb_name' => null,
'mb_nick' => null,
'mb_point' => null,
'mb_email' => null,
'mb_homepage' => null,
'mb_hp' => null,
'mb_tel' => null,
'mb_zip1' => null,
'mb_zip2' => null,
'mb_addr1' => null,
'mb_addr2' => null,
'mb_addr3' => null,
'mb_addr_jibeon' => null,
'mb_signature' => null,
'mb_profile' => null,
'mb_memo' => null,
'mb_leave_date' => null,
'mb_1' => null,
'mb_2' => null,
'mb_3' => null,
'mb_4' => null,
'mb_5' => null,
'mb_6' => null,
'mb_7' => null,
'mb_8' => null,
'mb_9' => null,
'mb_10' => null,
'mb_sdate' => null,
'mb_edate' => null,
'mb_doctor' => null,
'mb_birth' => null
);

$sound_only = '';
$required_mb_id_class = '';
$required_mb_password = '';

if ($w == '')
{
    $required_mb_id = 'required';
    $required_mb_id_class = 'required alnum_';
    $required_mb_password = 'required';
    $sound_only = '<strong class="sound_only">필수</strong>';

    $mb['mb_mailling'] = 1;
    $mb['mb_open'] = 1;
    $mb['mb_level'] = $config['cf_register_level'];
    $html_title = '추가';
}
else if ($w == 'u')
{   
    $mb = get_member($mb_id);
    if (!$mb['mb_id'])
        alert('존재하지 않는 회원자료입니다.');

    if ($is_admin != 'super' && $mb['mb_level'] >= $member['mb_level'])
        alert('자신보다 권한이 높거나 같은 회원은 수정할 수 없습니다.');

    $required_mb_id = 'readonly';
    $html_title = '수정';

    $mb['mb_name'] = get_text($mb['mb_name']);
    $mb['mb_nick'] = get_text($mb['mb_nick']);
    $mb['mb_email'] = get_text($mb['mb_email']);
    $mb['mb_homepage'] = get_text($mb['mb_homepage']);
    $mb['mb_birth'] = get_text($mb['mb_birth']);
    $mb['mb_tel'] = get_text($mb['mb_tel']);
    $mb['mb_hp'] = get_text($mb['mb_hp']);
    $mb['mb_addr1'] = get_text($mb['mb_addr1']);
    $mb['mb_addr2'] = get_text($mb['mb_addr2']);
    $mb['mb_addr3'] = get_text($mb['mb_addr3']);
    $mb['mb_signature'] = get_text($mb['mb_signature']);
    $mb['mb_recommend'] = get_text($mb['mb_recommend']);
    $mb['mb_profile'] = get_text($mb['mb_profile']);
    $mb['mb_1'] = get_text($mb['mb_1']);
    $mb['mb_2'] = get_text($mb['mb_2']);
    $mb['mb_3'] = get_text($mb['mb_3']);
    $mb['mb_4'] = get_text($mb['mb_4']);
    $mb['mb_5'] = get_text($mb['mb_5']);
    $mb['mb_6'] = get_text($mb['mb_6']);
    $mb['mb_7'] = get_text($mb['mb_7']);
    $mb['mb_8'] = get_text($mb['mb_8']);
    $mb['mb_9'] = get_text($mb['mb_9']);
    $mb['mb_10'] = get_text($mb['mb_10']);
    $mb['mb_sdate'] = get_text($mb['mb_sdate']);
    $mb['mb_edate'] = get_text($mb['mb_edate']);
    $mb['mb_doctor'] = get_text($mb['mb_doctor']);
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');

// 본인확인방법
switch($mb['mb_certify']) {
    case 'simple':
        $mb_certify_case = '간편인증';
        $mb_certify_val = 'simple';
        break;
    case 'hp':
        $mb_certify_case = '휴대폰';
        $mb_certify_val = 'hp';
        break;
    case 'ipin':
        $mb_certify_case = '아이핀';
        $mb_certify_val = 'ipin';
        break;
    case 'admin':
        $mb_certify_case = '관리자 수정';
        $mb_certify_val = 'admin';
        break;
    default:
        $mb_certify_case = '';
        $mb_certify_val = 'admin';
        break;
}

// 본인확인
$mb_certify_yes  =  $mb['mb_certify'] ? 'checked="checked"' : '';
$mb_certify_no   = !$mb['mb_certify'] ? 'checked="checked"' : '';

// 성인인증
$mb_adult_yes       =  $mb['mb_adult']      ? 'checked="checked"' : '';
$mb_adult_no        = !$mb['mb_adult']      ? 'checked="checked"' : '';

//메일수신
$mb_mailling_yes    =  $mb['mb_mailling']   ? 'checked="checked"' : '';
$mb_mailling_no     = !$mb['mb_mailling']   ? 'checked="checked"' : '';

// SMS 수신
$mb_sms_yes         =  $mb['mb_sms']        ? 'checked="checked"' : '';
$mb_sms_no          = !$mb['mb_sms']        ? 'checked="checked"' : '';

// 정보 공개
$mb_open_yes        =  $mb['mb_open']       ? 'checked="checked"' : '';
$mb_open_no         = !$mb['mb_open']       ? 'checked="checked"' : '';

if (isset($mb['mb_certify'])) {
    // 날짜시간형이라면 drop 시킴
    if (preg_match("/-/", $mb['mb_certify'])) {
        sql_query(" ALTER TABLE `{$g5['member_table']}` DROP `mb_certify` ", false);
    }
} else {
    sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `mb_certify` TINYINT(4) NOT NULL DEFAULT '0' AFTER `mb_hp` ", false);
}

if(isset($mb['mb_adult'])) {
    sql_query(" ALTER TABLE `{$g5['member_table']}` CHANGE `mb_adult` `mb_adult` TINYINT(4) NOT NULL DEFAULT '0' ", false);
} else {
    sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `mb_adult` TINYINT NOT NULL DEFAULT '0' AFTER `mb_certify` ", false);
}

// 지번주소 필드추가
if(!isset($mb['mb_addr_jibeon'])) {
    sql_query(" ALTER TABLE {$g5['member_table']} ADD `mb_addr_jibeon` varchar(255) NOT NULL DEFAULT '' AFTER `mb_addr2` ", false);
}

// 건물명필드추가
if(!isset($mb['mb_addr3'])) {
    sql_query(" ALTER TABLE {$g5['member_table']} ADD `mb_addr3` varchar(255) NOT NULL DEFAULT '' AFTER `mb_addr2` ", false);
}

// 중복가입 확인필드 추가
if(!isset($mb['mb_dupinfo'])) {
    sql_query(" ALTER TABLE {$g5['member_table']} ADD `mb_dupinfo` varchar(255) NOT NULL DEFAULT '' AFTER `mb_adult` ", false);
}

// 이메일인증 체크 필드추가
if(!isset($mb['mb_email_certify2'])) {
    sql_query(" ALTER TABLE {$g5['member_table']} ADD `mb_email_certify2` varchar(255) NOT NULL DEFAULT '' AFTER `mb_email_certify` ", false);
}

// 본인인증 내역 테이블 정보가 dbconfig에 없으면 소셜 테이블 정의
if( !isset($g5['member_cert_history']) ){
    $g5['member_cert_history_table'] = G5_TABLE_PREFIX.'member_cert_history';
}
// 멤버 본인인증 정보 변경 내역 테이블 없을 경우 생성
if(isset($g5['member_cert_history_table']) && !sql_query(" DESC {$g5['member_cert_history_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['member_cert_history_table']}` (
                    `ch_id` int(11) NOT NULL auto_increment,
                    `mb_id` varchar(20) NOT NULL DEFAULT '',
                    `ch_name` varchar(255) NOT NULL DEFAULT '',
                    `ch_hp` varchar(255) NOT NULL DEFAULT '',
                    `ch_birth` varchar(255) NOT NULL DEFAULT '',
                    `ch_type` varchar(20) NOT NULL DEFAULT '',
                    `ch_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
                    PRIMARY KEY (`ch_id`),
                    KEY `mb_id` (`mb_id`)
                ) ", true);
}

$mb_cert_history = '';
if (isset($mb_id) && $mb_id) {
    $sql = "select * from {$g5['member_cert_history_table']} where mb_id = '{$mb_id}' order by ch_id asc";
    $mb_cert_history = sql_query($sql);
}

if ($mb['mb_intercept_date']) $g5['title'] = "차단된 ";
else $g5['title'] .= "";
$g5['title'] .= '회원 '.$html_title;
include_once('./admin.head.php');

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

// 전체 전화번호 자른 후 보여주기.
$mb_hp = $mb['mb_hp'] ?? '';

$mb_hp1 = substr($mb_hp, 0, 3);   // ex ) 010
$mb_hp2 = substr($mb_hp, 3, 4);   // 중간자리
$mb_hp3 = substr($mb_hp, 7);      // 끝자리


//보호자 휴대폰 번호
$mb_tel = $mb['mb_tel'] ?? '';

$mb_tel1 = substr($mb_tel, 0, 3);   // ex ) 010
$mb_tel2 = substr($mb_tel, 3, 4);   // 중간자리
$mb_tel3 = substr($mb_tel, 7);      // 끝자리

?>

<!-- 달력 custom에 필요한 CND 다운로드 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ko.js"></script>

<form name="fmember" id="fmember" action="./member_form_update.php" onsubmit="return fmember_submit(this);" method="post" enctype="multipart/form-data">
<!-- <form name="fmember" id="fmember" method="post" enctype="multipart/form-data"> -->
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<script>
      var phpArray = <?= json_encode($mb, JSON_UNESCAPED_UNICODE); ?>;
      console.log("mb:" , phpArray)
</script>
<div class="mb_title">
    <h1>* 회원 정보</h1>
    <h1>* 진료 정보</h1>
</div>
<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>

    <!-- ID -->
    <tr>
        <th scope="row"><label for="mb_id">아이디(차트번호)<?php echo $sound_only ?></label></th>
        <td>
            <input type="text" name="mb_id" value="<?php echo $mb['mb_id'] ?>" id="mb_id" <?php echo $required_mb_id ?> class="frm_input <?php echo $required_mb_id_class ?>" size="15"  maxlength="20">
            <?php if ($w=='u'){ ?><a href="./boardgroupmember_form.php?mb_id=<?php echo $mb['mb_id'] ?>" class="btn_frmline">접근가능그룹보기</a><?php } ?>
        </td>
    </tr>

    <!-- PW -->
    <tr>
        <th scope="row"><label for="mb_password">비밀번호<?php echo $sound_only ?></label></th>
        <td><input type="password" name="mb_password" id="mb_password" <?php echo $required_mb_password ?> class="frm_input <?php echo $required_mb_password ?>" size="15" maxlength="20"></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_name">이름(실명)<strong class="sound_only">필수</strong></label></th>
        <td><input type="text" name="mb_name" value="<?php echo $mb['mb_name'] ?>" id="mb_name" required class="required frm_input" size="15"  maxlength="20"></td>
    </tr>

    <tr>
        <th scope="row"><label for="mb_birth">생년월일<strong class="sound_only">필수</strong></label></th>
        <td>
            <input type="text" name="mb_birth" value="<?php echo $mb['mb_birth'] ?>" id="mb_birth" required class="required frm_input datepicker"  size="15" max="9999-12-31"  onclick="birth()">
            <label for="mb_nick">ex) 2003-01-01</label>
        </td>
    </tr>

    <tr>
        <th scope="row"><label for="mb_level">회원 권한</label></th>
        <td>
            <span class="frm_box">교정 중인 경우 권한 6, 교정 마무리 후 권한 5로 변경</span>
            <select name="mb_level" id="mb_level">
                <?php 
                    $mb_code = ['회원' , '의료진' , '관리자'];
                    $mb_level = ['6' , '9' , '10'];

                    for ($i = 0; $i < count($mb_code); $i++){
                        $level_checked = $mb_level[$i] == $mb['mb_level'] ? 'selected' : '';
                ?>
                <option value="<?= $mb_level[$i]?>" <?=$level_checked?> ><?=$mb_code[$i]?></option>
                <? }?>
            </select>
           
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_8">성별<strong class="sound_only">필수</strong></label></th>
        <td>
            <input type="radio" name="mb_8" value="남" id="mb_man" required class="required frm_input" <?=$mb['mb_8'] =='남'? 'checked' : '' ?>>
            <label for="mb_man">남자</label>
            <input type="radio" name="mb_8" value="여" id="mb_woman" required class="required frm_input" <?=$mb['mb_8'] =='여'? 'checked' : '' ?>>
            <label for="mb_woman">여자</label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="mb_hp">휴대폰번호</label>
        </th>
        <td>
            <select name="mb_hp1" id="mb_hp1">
                <?php 
                    $mb_tel = ['010','011','032'];

                    for ($i = 0; $i < count($mb_tel); $i++){
                        $tel_checked = $mb_tel[$i] == $mb_hp1 ? 'selected' : '';
                ?>
                        <option value="<?= $mb_tel[$i] ?>"<?=$tel_checked?>><?= $mb_tel[$i] ?></option>
                <?php } ?>
            </select> - 
            <input type="text" name="mb_hp2" value="<?=$mb_hp2 ?>" id="mb_hp2" class="frm_input" required size="4" maxlength="4"> -
            <input type="text" name="mb_hp3" value="<?=$mb_hp3 ?>" id="mb_hp3" class="frm_input" required size="4" maxlength="4">
        </td>
    </tr>
    <tr>
    <th scope="row">
            <label for="mb_tel">보호자 휴대폰번호</label>
        </th>
        <td>
            <select name="mb_tel1" id="mb_tel1">
                <?php 
                    $mb_tel = ['010','011','032'];

                    for ($i = 0; $i < count($mb_tel); $i++){
                        $tel_checked = $mb_tel[$i] == $mb_tel1 ? 'selected' : '';
                ?>
                        <option value="<?= $mb_tel[$i] ?>"<?=$tel_checked?>><?= $mb_tel[$i] ?></option>
                <?php } ?>
            </select> -
            <input type="text" name="mb_tel2" value="<?=$mb_tel2 ?>" id="mb_tel2" class="frm_input" required size="4" maxlength="4"> -
            <input type="text" name="mb_tel3" value="<?=$mb_tel3 ?>" id="mb_tel3" class="frm_input" required size="4" maxlength="4">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_img">회원이미지</label></th>
        <td>
            <?php echo help('이미지 크기는 <strong>넓이 '.$config['cf_member_img_width'].'픽셀 높이 '.$config['cf_member_img_height'].'픽셀</strong>로 해주세요.') ?>
            <input type="file" name="mb_img" id="mb_img">
            <?php
            $mb_dir = substr($mb['mb_id'],0,2);
            $icon_file = G5_DATA_PATH.'/member_image/'.$mb_dir.'/'.get_mb_icon_name($mb['mb_id']).'.gif';
            if (file_exists($icon_file)) {
                echo get_member_profile_img($mb['mb_id']);
                echo '<input type="checkbox" id="del_mb_img" name="del_mb_img" value="1">삭제';
            }
            ?>
        </td>
    </tr>

    </tbody>
    </table>
    
    <table>
    <tbody>
    <tr>
        <th scope="row"><label for="mb_signature">담당 의료진</label></th>
        <td colspan="3">
            <input type="radio" name="mb_doctor" value="이채경원장님" id="mb_doctor1" <?=$mb['mb_doctor'] =='이채경원장님'? 'checked' : '' ?>>
            <label for="mb_doctor1">이채경 원장님</label>
            <input type="radio" name="mb_doctor" value="황우상원장님" id="mb_doctor2" <?=$mb['mb_doctor'] =='황우상원장님'? 'checked' : '' ?>>
            <label for="mb_doctor1">황우상 원장님</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_sdate">치료 시작일</label></th>
        <td colspan="3">
            <input type="text" id="mb_sdate" class="frm_input datepicker" name="mb_sdate" value="<?php echo $mb['mb_sdate']; ?>">
            <label for="mb_sdate">ex)연도-월-일</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_edate">치료종료예상일</label></th>
        <td colspan="3">
            <input type="text" name="mb_edate" id="mb_edate" class="frm_input datepicker" max="9999-12-31"  value="<?php echo $mb['mb_edate'] ?>">
            <label for="mb_edate">ex)연도-월-일</label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="mb_case">CASE</label>
        </th>
        <td colspan="3">
            <?php 
            //$mb_2를 배열로 변환
            $mb['mb_2'] = explode(",", $mb['mb_2']); // 콤마로 구분

            $member_case = ["돌출", "덧니", "치아사이공간", "개방교합", "과개교합", "반대교합", "비수술주걱턱", "비수술무턱", 
                            "수술교정", "재교정", "소아교정", "치열불규칙"];

            for($i = 0; $i < count($member_case); $i++) {
                $case_checked = in_array($member_case[$i], $mb['mb_2']) ? 'checked' : '';
            ?>
                <input type="checkbox"  name="mb_2[]" value="<?= $member_case[$i]; ?>" id="case<?=$i;?>" <?=$case_checked?>>
                <label for="case<?= $i ?>"><?= $member_case[$i]; ?>&nbsp;&nbsp;</label>
    <?php } ?>
        </td>
    </tr>

    <!-- 치료형태 -->

    <tr>
        <th scope="row">
            <label for="trea_type">치료형태</label>
        </th>
        <td colspan="3">
            <ul>
                <li>
                    <span class="trea_box">발치 진행 유무</span>
                    <input type="radio" id="trea_type_0101" name="mb_3" value="발치" <?=$mb['mb_3'] == "발치" ? 'checked' : ''?>>
                    <label for="trea_type_0101">발치&nbsp;</label>
                    <input type="radio" id="trea_type_0102" name="mb_3" value="비발치" <?=$mb['mb_3'] == "비발치" ? 'checked' : ''?>>
                    <label for="trea_type_0102">비발치&nbsp;</label>
                </li>
                <li>
                    <span class="trea_box">교정 범위</span>
                    <input type="radio" id="trea_type_0201" name="mb_4" value="전체" <?=$mb['mb_4'] == "전체" ? 'checked' : ''?>>
                    <label for="trea_type_0201">전체&nbsp;</label>
                    <input type="radio" id="trea_type_0202" name="mb_4" value="부분" <?=$mb['mb_4'] == "부분" ? 'checked' : ''?>>
                    <label for="trea_type_0202">부분&nbsp;</label>
                </li>
                <li>
                    <span class="trea_box">교정 부위</span>
                    <input type="radio" id="trea_type_0301" name="mb_5" value="순측" <?=$mb['mb_5'] == "순측" ? 'checked' : ''?>>
                    <label for="trea_type_0301">순측&nbsp;</label>
                    <input type="radio" id="trea_type_0302" name="mb_5" value="설측" <?=$mb['mb_5'] == "설측" ? 'checked' : ''?>>
                    <label for="trea_type_0302">설측&nbsp;</label>
                    <input type="radio" id="trea_type_0302" name="mb_5" value="콤비" <?=$mb['mb_5'] == "콤비" ? 'checked' : ''?>>
                    <label for="trea_type_0302">콤비&nbsp;</label>
                </li>
                <!-- 그누보드 기본 설정인진 모르겠으나 , '악'이라는 단어를 인식하지 않음 -->
                <li>
                    <span class="trea_box">교정 약궁</span>
                    <input type="radio" id="trea_type_0401" name="mb_6" value="양" <?=$mb['mb_6'] == "양" ? 'checked' : ''?>>
                    <label for="trea_type_0401">양악&nbsp;</label>
                    <input type="radio" id="trea_type_0402" name="mb_6" value="상" <?=$mb['mb_6'] == "상" ? 'checked' : ''?>>
                    <label for="trea_type_0402">상악&nbsp;</label>
                    <input type="radio" id="trea_type_0403" name="mb_6" value="하" <?=$mb['mb_6'] == "하" ? 'checked' : ''?>>
                    <label for="trea_type_0403">하악&nbsp;</label>
                </li>
            </ul>


            <!-- 치료형태 배열 및 for문 / 사용시 마지막 mb_6를 인식 못함(why!!!!!!!!)-->
                <!-- <?php 
                    $trea_type = ["발치 진행 유무", "교정 범위", "교정 부위", "교정 악궁"];
                    $trea_sub_type = [
                        ["발치", "비발치"], // 발치 진행 유무
                        ["전체", "부분"],   // 교정 범위
                        ["순측", "설측", '콤비'],   // 교정 부위
                        ["양악", "상악", "하악"] // 교정 악궁
                    ];

                for ($i = 0; $i < count($trea_type); $i++) {
                    $trea_index = str_pad($i, 2, "0", STR_PAD_LEFT);  
                ?>
                <li>
                    <span class="trea_box"><?= $trea_type[$i]; ?></span>

                    <?php 
                    // 각 교정 타입에 따른 서브 타입을 출력
                    for ($a = 0; $a < count($trea_sub_type[$i]); $a++) {
                        $sub_trea_index = str_pad($a, 2, "0", STR_PAD_LEFT); // 서브 인덱스

                        $checked = isset($mb['mb_' . ($i + 4)]) && $mb['mb_' . ($i + 4)] == $trea_sub_type[$i][$a] ? 'checked' : '';
                    ?>
                        <input type="radio" id="trea_type<?=$trea_index?>_<?=$sub_trea_index?>" name="mb_<?=$i + 4?>" value="<?= $trea_sub_type[$i][$a]?>" <?=$checked?>>
                        <label for="trea_type<?=$trea_index?>_<?=$sub_trea_index?>"><?=$trea_sub_type[$i][$a];?>&nbsp;</label>
                    <?php } ?>
                </li>
                 <?php } ?> -->
            </ul>
        </td>
    </tr>
    
    <!-- 치료장치 -->
    <tr>
        <th scope="row">
            <label for="trea_device">치료장치</label>
        </th>
        <td colspan="3">
            <?php 
                $trea_device = ['클리피엠', '클리피씨' ,'데이몬클리어', 'CA투명교정', '인비절라인' ,'클리피엘' ,'MTA'];

               
                for($i = 0; $i < count($trea_device); $i++) {
                    $trea_checked = $trea_device[$i] == $mb['mb_7'] ? 'checked' : '';
                ?>
                    <input type="radio" value="<?= $trea_device[$i]; ?>" id="device<?=$i;?>" name="mb_7" <?=$trea_checked?>>
                    <label for="device<?= $i ?>"><?= $trea_device[$i]; ?>&nbsp;&nbsp;</label>
            <?php } ?>
        </td>
    </tr>

    
    <?php for ($i=1; $i<=10; $i++) { ?>
   <!-- <tr>
        <th scope="row"><label for="mb_<?php echo $i ?>">여분 필드 <?php echo $i ?></label></th>
        <td colspan="3"><input type="text" name="mb_<?php echo $i ?>" value="<?php echo $mb['mb_'.$i] ?>" id="mb_<?php echo $i ?>" class="frm_input" size="30" maxlength="255"></td>
         <td colspan="3"><input type="text" name="mb_<?php echo $i ?>[]" value="<?php echo $mb['mb_'.$i] ?>" id="mb_<?php echo $i ?>" 
    </tr> -->
    <?php } ?>

    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./member_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey='s'>
</div>
</form>

<div id="response-message">

</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ko.js"></script>

<script>
    // flatpickr 초기화
    document.addEventListener('DOMContentLoaded', function() {
        const fields = ["#mb_sdate", "#mb_edate", "#mb_birth"]; //달력 사용 태그들
        fields.forEach(selector => {
            flatpickr(selector, {
                dateFormat: "Y-m-d", // 날짜 형식
                maxDate: "9999-12-31", // 최대 날짜 제한
                minDate: "1900-01-01", // 최소 날짜 제한
                locale: "ko", // 한글화
            });
        });
    });
    
    //  document.getElementById('fmember').addEventListener('submit', function(event) {
    //      event.preventDefault(); // 기본 제출 방지
        
    //      // AJAX 요청을 통해 데이터 전송
    //      const formData = new FormData(this);

    //      for (const [key, value] of formData.entries()) {
    //     console.log(`${key}: ${value}`);
    //      }
        
    //      fetch(this.action, {
    //          method: this.method,
    //          body: formData,
    //      })
    //      .then(response => response.text())
    //      .then(data => {
    //          // 서버에서 반환된 메시지 출력
    //          document.getElementById('response-message').innerText = data;
    //      })
    //      .catch(error => {
    //          console.error('Error:', error);
    //     });
    //  }); 


    $(document).on('change', 'input[type="checkbox"]', function() {
        var name = $(this).attr('name');
        var value = $(this).val();
        console.log("Name: " + name + ", 선택된 값: " + value);
    });

    $(document).on('change', 'input[type="radio"]', function() {
        var name = $(this).attr('name');
        var value = $(this).val();
        console.log("Name: " + name + ", 선택된 값: " + value);
    });

    const birth = () => {
        var birth_date = $('input[type="date"]').val(); 
        console.log("birth : "+ birth_date)
       
    };

    for (let i = 3; i <= 6; i++) {
    var selected = $('input[name="mb_' + i + '"]:checked').val();
    console.log("mb_" + i + "의 선택된 값: " + selected);
    var selected = $()
    }

    document.addEventListener("DOMContentLoaded", function () {
        const hp1 = document.getElementById("mb_hp1");
        const hp2 = document.getElementById("mb_hp2");
        const hp3 = document.getElementById("mb_hp3");

        hp1.addEventListener("input", function () {
            if (hp1.value.length === 4) hp2.focus();
        });
        hp2.addEventListener("input", function () {
            if (hp2.value.length === 4) hp3.focus();
        });
    });
        //  $.ajax({
        //      url: './member_form_update.php',
        //     type: 'POST',
        //     dataType: 'json',
        //     data: {
        //         mb_id : '',
        //         mb_name: '',
        //         mb_nick: '' ,
        //         mb_level: '',
        //         mb_tel: '',
        //         mb_hp: '' ,
        //         mb_birth : '',
        //         mb_memmo : '',
        //         mb_2 : '',
        //         mb_3 : '',
        //         mb_4 : '',
        //         mb_5 : '',
        //         mb_6 : '',
        //         mb_7 : '',
        //         mb_sdate : ''.
        //         mb_edate : ''
        //         mb_doctor: '',

        //      }
        //      async: false,
        //      success: function(data, textStatus) {
        //      if (data.error) {
        //              alert(data.error);
        //              return false;
        //          }
        //      }
        //      error: function(xhr, status, error) {
        //          console.error("AJAX Error: " + error);
        //          console.error("Response text: " + xhr.responseText); // 서버의 응답 내용 출력
        //          alert("서버 오류가 발생했습니다. 관리자에게 문의하세요.");
        //      }
        //  });

    function fmember_submit(f){


        if (!f.mb_icon.value.match(/\.(gif|jpe?g|png)$/i) && f.mb_icon.value) {
            alert('아이콘은 이미지 파일만 가능합니다.');
            return false;
        }

        if (!f.mb_img.value.match(/\.(gif|jpe?g|png)$/i) && f.mb_img.value) {
            alert('회원이미지는 이미지 파일만 가능합니다.');
            return false;
        }
        
        return true;
    }
</script>

<?php
run_event('admin_member_form_after', $mb, $w);

include_once('./admin.tail.php');
<?php
$location = 'notice';
$main_menu = '200000';
$head_menu = $main_menu;
$page_key = 'mode';
//$login_access = 'N';

//그누보드
define('_GNUBOARD_', true);
include_once ($_SERVER['DOCUMENT_ROOT'].'/common.php');

// mode 값이 없을 경우 기본값 설정
$get_mode = !empty($_REQUEST[$page_key]) ? trim($_REQUEST[$page_key]) : 'list';

// 접근 가능한 mode
$access_mode = array('content', 'list', 'form', 'show', 'edit', 'insert', 'update', 'delete');

// 유효하지 않은 mode일 경우 경고
if (!in_array($get_mode, $access_mode)) {
    die("<script>alert('해당 페이지는 접근할 수 없습니다.');</script>");
}

// 예외 처리 mode
$ex_mode = array(
    'insert' => 'enroll',
    'update' => 'enroll_update',
    'delete' => 'enroll_delete',
);

// 예외 처리된 mode값 설정
$get_mode = $ex_mode[$get_mode] ?? $get_mode;

// 로그인하지 않은 경우 예외처리
/*
if ($login_access === 'Y' && empty($member['mb_id'])) {
    die("<script>alert('로그인 후 접근 가능합니다.'); window.history.back();</script>");
}
*/

// 해당 페이지 로딩
include_once($_SERVER['DOCUMENT_ROOT']. "/board/{$location}/{$get_mode}.php");
<?php
// board
$bo_table = 'notice';
$board = get_board_db($bo_table);

// editor
$is_dhtml_editor = $board['bo_use_dhtml_editor'];
// file
$is_file = $board['bo_upload_count'] > 0;
$file_count = $board['bo_upload_count'] ?? 0;
// captcha
$is_use_captcha = $board['bo_use_captcha'] && !is_mobile() ? 1 : 0;

$sub_menu = 200100;
include_once (G5_EDITOR_PATH."/{$board['bo_select_editor']}/editor.lib.php");
include_once(G5_CAPTCHA_PATH . '/captcha.lib.php');

include_once (G5_PATH.'/head.php');

$token = get_token();
set_session("ss_write_{$bo_table}_token", $token);

// 토큰을 생성해서 ss_write_{$bo_table}_token 에 저장
//$token = get_write_token($bo_table);


// wr_name
$wr_name = $member['mb_name'] ?? '';

print_r2($_SESSION);

?>
<!-- css -->
<link rel="stylesheet" href="/board/notice/style.css?ver=<?=time()?>">

<div class="board-form">
    <h1 class="board-title">글쓰기</h1>

    <form name="fwrite" id="fwrite" method="post" action="/bbs/write_update.php" enctype="multipart/form-data" onsubmit="return fwrite_submit(this);">
        <input type="hidden" name="token" value="<?= $token ?>">
        <input type="hidden" name="bo_table" value="<?= $bo_table ?>">
        <input type="hidden" name="custom_url" value="/board/notice/?mode=list">
        <?php if($member['mb_id']):?>
        <input type="hidden" name="wr_name" value="<?=  $wr_name ?>">
        <?php endif;?>

        <?php if(!$member['mb_id']):?>
        <div class="form-row">
            <label for="wr_name">이름</label>
            <input type="text" name="wr_name" id="wr_name" required>
        </div>

        <div class="form-row">
            <label for="wr_password">비밀번호</label>
            <input type="text" name="wr_password" id="wr_password">
        </div>
        <?php endif;?>

        <div class="form-row">
            <label for="wr_subject">제목</label>
            <input type="text" name="wr_subject" id="wr_subject" required>
        </div>

        <div class="form-row">
            <label for="wr_content">내용</label>
            <div class="wr_content <?= $board['bo_select_editor'] ?>">
                <?= editor_html('wr_content', '', $is_dhtml_editor) ?>
            </div>
        </div>

        <div class="form-row">
            <label>파일첨부</label>
            <?php for ($i = 0; $i < $file_count; $i++) { ?>
                <input type="file" name="bf_file[]">
            <?php } ?>
        </div>

        <?php if ($is_use_captcha): //자동등록방지?>
        <div class="write_div">
            <?php echo captcha_html() ;?>
        </div>
        <?php endif; ?>


        <div class="form-row submit-row">
            <div class="left-buttons">
                <a href="/board/notice/?mode=list" class="btn btn-list">목록</a>
            </div>
            <div class="center-buttons">
                <button type="submit" class="btn btn-submit">작성완료</button>
            </div>
        </div>
    </form>
</div>

<script>
    function fwrite_submit(f){
        //editor
        <?php echo get_editor_js('wr_content', $is_dhtml_editor);?>
        <?php echo chk_editor_js('wr_content', $is_dhtml_editor);?>

        //captcha
        <?php echo chk_captcha_js() ;?>

        return true;
    }
</script>

<?php
include_once(G5_PATH.'/tail.php');

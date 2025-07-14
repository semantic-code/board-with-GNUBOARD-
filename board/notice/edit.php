<?php
$sub_menu = 200100;
//wr_id
$wr_id = !empty($_GET['wr_id']) ? trim($_GET['wr_id']) : '';

//board
$bo_table = 'notice';
$board = get_board_db($bo_table);

//editor
$is_dhtml_editor = $board['bo_use_dhtml_editor'];
include_once (G5_EDITOR_PATH."/{$board['bo_select_editor']}/editor.lib.php");
include_once(G5_CAPTCHA_PATH . '/captcha.lib.php');

//head
include_once (G5_PATH.'/head.php');

set_session("ss_bo_table", $bo_table);
set_session('ss_wr_id', $wr_id);

$sql = "SELECT * FROM {$g5['write_prefix']}{$bo_table} WHERE (1) AND wr_id = {$wr_id}";
$row = sql_fetch($sql);

$list = get_list($row, $board, '', '');
$list['file'] = get_file($bo_table, $wr_id);

//file
$is_file = $board['bo_upload_count'] > 0;
$file_count = $board['bo_upload_count'] ?? 0;
//captcha
$is_use_captcha = $board['bo_use_captcha'] && !is_mobile() ? 1 : 0;
if($is_use_captcha){
    $captcha_html = captcha_html();
    $captcha_js   = chk_captcha_js();
}

?>
    <!-- css -->
    <link rel="stylesheet" href="/board/notice/style.css?ver=<?=time()?>">

    <div class="board-form">
        <h1 class="board-title">글쓰기</h1>

        <form name="fwrite" id="fwrite" method="post" action="/bbs/write_update.php" enctype="multipart/form-data" onsubmit="return fwrite_submit(this);">
            <input type="hidden" name="bo_table" value="<?= $bo_table ?>">
            <input type="hidden" name="wr_id" value="<?= $wr_id ?>">
            <input type="hidden" name="w" value="u">
            <input type="hidden" name="custom_url" value="/board/notice/?mode=show&wr_id=<?= $wr_id ?>">

            <div class="form-row">
                <label for="wr_name">이름</label>
                <input type="text" name="wr_name" id="wr_name" required value="<?=$list['wr_name']?>">
            </div>

            <div class="form-row">
                <label for="wr_subject">제목</label>
                <input type="text" name="wr_subject" id="wr_subject" required value="<?=$list['wr_subject']?>">
            </div>

            <div class="form-row">
                <label for="wr_content">내용</label>
                <div class="wr_content <?= $board['bo_select_editor'] ?>">
                    <?= editor_html('wr_content', $list['wr_content'], $is_dhtml_editor) ?>
                </div>
            </div>

            <?php $file = $list['file']; ?>
            <div class="file_wrap">
                <h3>파일첨부</h3>
                <?php for ($i = 0; $is_file && $i < $file_count; $i++):?>
                <div class="form-row">
                    <input type="file" name="bf_file[]">
                    <div class="file-info">
                    <?php if($file[$i]['source']):?>
                    <span>파일명 : <?= $file[$i]['source'] ?></span>
                    <span class="file-delete">
                        <label>
                            <input type="checkbox" name="bf_file_del[<?= $i ?>]" value="1">
                            <span>삭제</span>
                        </label>
                    </span>
                    <?php endif;?>
                </div>            
                <?php endfor;?>
            </div>

            <?php if ($is_use_captcha): //자동등록방지?>
            <div class="write_div">
                <?php echo $captcha_html ;?>
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
            <?php echo $captcha_js ;?>

            return true;
        }
    </script>

<?php
include_once(G5_PATH.'/tail.php');

<?php
$wr_id = !empty($_GET['wr_id']) ? $_GET['wr_id'] : 0;

$sub_menu = 200100;
include_once (G5_PATH.'/head.php');

// board
$bo_table = 'notice';
$board = get_board_db($bo_table);
$is_dhtml_editor = $board['bo_use_dhtml_editor'];
$bo_select_editor = $board['bo_select_editor'];

// view
$sql = "SELECT * FROM {$g5['write_prefix']}{$bo_table} WHERE wr_id = $wr_id";
$result = sql_query($sql);
$row = sql_fetch_array($result);
$view = get_view($row, $board, '');
$view['file'] = get_file($bo_table, $wr_id);

$file = $view['file'];

?>
<!-- css -->
<link rel="stylesheet" href="/board/notice/style.css?ver=<?=time()?>">

<div class="board-view">
    <h1 class="view-title"><?=$view['wr_subject']?></h1>

    <div class="view-meta">
        작성자: <?=$view['wr_name']?> | 작성일: <?=$view['wr_datetime']?>
    </div>

    <div class="view-content">
        <?=$view['wr_content']?>
    </div>

    <div class="view-file">
        <?php for($i = 0; $i < $file['count']; $i++):?>
            <span>첨부파일 <?= $i +1; ?> : </span>
            <span>
                <a href="<?= $file[$i]['path'] ?>/<?= $file[$i]['file'] ?>" download="<?= $file[$i]['source'] ?>">
                    <span><?= $file[$i]['source'] ?></span>
                </a>
            </span>
        <?php endfor; ?>
    </div>

    <div class="btn-area">
        <a href="<?=dirname($_SERVER['PHP_SELF'])?>/?mode=edit&wr_id=<?= $view['wr_id'] ?>" class="btn btn-list">수정</a>
        <a href="<?=dirname($_SERVER['PHP_SELF'])?>/?mode=list" class="btn btn-write">목록</a>
    </div>
</div>

<?php
include_once(G5_PATH.'/tail.php');
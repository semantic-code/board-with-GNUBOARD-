<?php
// board
$bo_table = 'notice';
$board = get_board_db($bo_table);

$sub = 200100;
include_once (G5_PATH.'/head.php');

// paging
$page = ($_GET['page']) ?? 1;
$total_count = $board['bo_count_write']; //총 레코드
$page_rows = $board['bo_page_rows']; //페이지당 레코드

$total_page = ceil($total_count / $page_rows); //전체 페이지 계산
$start_record = ($page - 1) * $page_rows; //시작 레코드

$page_block = 5;

$paging = get_paging($page_block, $page, $total_page, dirname($_SERVER['PHP_SELF']).'/?mode=list');

// order_by
$order_by = $board['bo_sort_field'] ? "ORDER BY {$board['bo_sort_field']}" : "";

// list
$sql = "SELECT * FROM {$g5['write_prefix']}{$bo_table} WHERE (1) AND wr_is_comment = 0 {$order_by} LIMIT {$start_record}, {$page_rows}";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)){
    $list[] = get_list($row, $board, '', '');
}
?>
<link rel="stylesheet" href="/board/notice/style.css?ver=<?=time()?>">
<div class="board-list">
    <h1 class="board-title">게시판 목록</h1>
    <table class="board-table">
        <thead>
        <tr>
            <th class="num">번호</th>
            <th class="subject">제목</th>
            <th class="name">작성자</th>
            <th class="date">날짜</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $index => $row):?>
        <?php $virtual_number = intval(($total_count) - ($index + $start_record)); ?>
        <tr>
            <td class="num"><?=$virtual_number?></td>
            <td class="subject">
                <a href="<?=dirname($_SERVER['PHP_SELF'])?>/?mode=show&wr_id=<?=$row['wr_id']?>">
                    <?=$row['wr_subject']?>
                </a>
            </td>
            <td class="name"><?=$row['wr_name']?></td>
            <td class="date"><?=$row['wr_datetime']?></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div class="paging">
        <?=$paging;?>
    </div>

    <div class="btn-area">
        <a href="<?=dirname($_SERVER['PHP_SELF'])?>/?mode=form" class="btn btn-write">글쓰기</a>
    </div>
</div>

<?php
include_once(G5_PATH.'/tail.php');
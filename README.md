write_update.php
1. 입력 모드
   - $token = get_token
   - session : set_session("ss_write_{$bo_table}_token", $token);
   - input hidden : name = token, value = $token
   - input hidden : name = board, value = 'notice'
     
2. 수정 모드
   - session : set_session("ss_bo_table", 'notice');
   - session : set_session('ss_wr_id', 10);
   - input hidden : name = wr_id, value = 10
   - input hidden : name = board , value = 'notice'
   - input hidden : name = w, value = u

  
/skin/board/notice/write_update.skin.php
   - if($custom_url) goto_url($custom_url);

/bbs/write_update.php
   - 자동등록방지 숫자가 틀렸습니다. 경고창 부분 예외 처리

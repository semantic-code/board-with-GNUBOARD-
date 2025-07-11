write_update.php
1. 입력 모드
   - session : set_session("ss_write_{$bo_table}_token", $token);
   - input hidden : name = token, value = get_token()
   - input hidden : name = board, value = 'notice'
     
3. 수정 모드
   - session : set_session("ss_bo_table", $bo_table);
   - session : set_session('ss_wr_id', $wr_id);
   - input hidden : name = wr_id, value = 10
   - input hidden : name = board , value = 'notice'
   - input hidden : name = w, value = u

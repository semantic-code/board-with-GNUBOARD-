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
  
write_update.skin.php
- if($custom_url) goto_url($custom_url);


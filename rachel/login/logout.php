<?php
  session_start();
  session_destroy();
?>
<script>
  alert("로그아웃되었습니다.");
  location.replace('../index.php?page=1');
</script>
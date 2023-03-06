<?php
  session_start();

  // 한글 깨짐 방지
  header('Content-Type: text/html; charset=utf-8');

  // new mysqli("주소", "db id", "db password", "db name")
  $db = new mysqli("222.239.14.105", "rookie_user_rachel", "fnzlWkd!!!", "rookie_rachel");
  $db->set_charset("utf8mb4");

  function query($query)
  {
    global $db;
    return $db->query($query);
  }
?>
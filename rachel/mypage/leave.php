<?php
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";

  $id = $_POST['id'];
  $pw = $_POST['now'];

  $sql1 = query("SELECT * FROM userinfo WHERE id = '".$id."' LIMIT 1");
  $result = $sql1->fetch_array();
    
  // db에 저장된 암호화된 pw
  $db_pw = $result['pw'];

  // 사용자 입력 pw와 디비pw가 같으면 탈퇴
  if( password_verify($pw, $db_pw) ){
    $sql = query("delete from userinfo where id='$id';");
    session_destroy();

    echo "<script>alert('탈퇴되었습니다.');
    location.replace('/rachel/index.php?page=1');</script>";
    
  }else{
    echo "<script>alert('비밀번호가 다릅니다. 다시 확인해주세요');
    history.back();</script>";
  }


?>
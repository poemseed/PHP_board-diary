<?php
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";

  $userid = $_POST['id'];
  $userpw = $_POST['pw'];
  
  if($userid && $userpw){
    // $sql = query("SELECT * FROM userinfo WHERE id = '".$userid."' AND pw = '".$userpw."'");
    $sql = query("SELECT * FROM userinfo WHERE id = '".$userid."' LIMIT 1");
    $result = $sql->fetch_array();
    
    // db에 저장된 암호화된 pw
    $db_pw = $result['pw'];

    // 사용자 입력 pw와 디비pw가 같으면 로그인
    if( password_verify($userpw, $db_pw) ){
      $_SESSION['userId'] = $result['id'];
      $_SESSION['userName'] = $result['userName'];
      $_SESSION['userIdx'] = $result['userIdx'];
      
      echo "<script>location.replace('../index.php?page=1');</script>";
    
    }else{
      echo "<script>alert('로그인에 실패했습니다. 아이디와 비밀번호를 확인하십시오.')</script>";

      echo "<script>location.replace('login.php');</script>";
    }
  }
?>
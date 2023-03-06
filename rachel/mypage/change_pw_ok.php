<?php
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";

  $userid = $_POST['id'];
  $userpw = $_POST['pre'];
  $newuserpw = $_POST['new'];
  
  if($userid && $userpw && $newuserpw){
    // $sql = query("SELECT * FROM userinfo WHERE id = '".$userid."' AND pw = '".$userpw."'");
    $sql = query("SELECT * FROM userinfo WHERE id = '".$userid."' LIMIT 1");
    $result = $sql->fetch_array();
    
    // db에 저장된 암호화된 pw
    $db_pw = $result['pw'];

    // 사용자 입력 pw와 디비pw가 같으면 비밀번호 수정
    if( password_verify($userpw, $db_pw) ){
      // 새 비밀번호 암호화
      $encrypted_pw = password_hash($newuserpw, PASSWORD_DEFAULT);

      $sql = query("update userinfo set pw='".$encrypted_pw."' where id='".$userid."'");
      
      echo "<script>alert('비밀번호가 수정되었습니다.');location.replace('./mypage.php');</script>";
    
    }else{
      echo "<script>alert('비밀번호수정에 실패했습니다. 비밀번호를 다시 확인하십시오.')</script>";
      echo "<script>history.back();</script>";
    }
  }
?>
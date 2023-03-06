<?php 
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";

  // 각 변수에 input name 값을 저장
  $id = $_POST['id'];
  $pw = $_POST['pw'];
  $name = $_POST['userName'];

  //id 중복확인
  $sql1 = query("select * from userinfo where id = '".$id."'");
  $result = mysqli_num_rows($sql1);

  if( $id && $pw && $name ){
    // 중복되면 돌아가기
    if( $result ){
      echo "<script>
      alert('아이디가 중복됩니다. 변경해주세요.');
      history.back();</script>";
    }else{
      // 최근유저 삭제 후 가입하면 자동시퀀스 번호 삭제된 유저 번호로 시작하기
      $mqq = query("alter table userinfo auto_increment = 1");

      // 비밀번호 암호화
      $encrypted_pw = password_hash($pw, PASSWORD_DEFAULT);

      $sql = query("insert into userinfo(id, pw, userName) values('".$id."','".$encrypted_pw."','".$name."')");
      echo "<script>
      alert('회원가입이 완료되었습니다.');
      location.href='login.php';</script>";

    }
  }else{
    echo "<script>
    alert('회원가입에 실패했습니다. 다시 한번 확인해주세요');
    history.back();</script>";
  }

?>
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";?>
<!-- meta가져오기(네비에 사용되는 세션에 저장된userId 소스 포함) -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>
<?php  
  $sql = query("SELECT * FROM userinfo WHERE id='".$userid."'");
  $user = $sql->fetch_array();
?>
<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <!-- 게시판 타이틀 -->
  <h2 id="boardTitle">
    <span class="material-symbols-outlined">house</span>
    내정보
    <span class="material-symbols-outlined">deceased</span>
  </h2>
  <form action="change_pw_ok.php" method="post" name="pwChangeForm" onsubmit="return checkPw()">
    <table class="mypage-table">
      <tr>
        <td>이름</td>
        <td><input type="text" value="<?php echo $user['userName'] ?>" readonly></td>
      </tr>
      <tr>
          <td>아이디</td>
          <td><input type="text" name="id" value="<?php echo $user['id'] ?>" readonly></td>
      </tr>
      <tr id="pwBtn">
        <td>비밀번호</td>
        <td class="text-align-center">
          <a href="javascript:void(0);" onclick="changePw();">수정하기</a>
        </td>
      </tr>
      <tr id="">
        <td>탈퇴</td>
        <td class="text-align-center">
          <a href="javascript:void(0);" onclick="leave();" id="leaveBtn">탈퇴하기</a>
        </td>
      </tr>
      <!-- 탈퇴하기 비번확인 -->
      <tr id="leavePw" class="hidden">
        <td><label for="nowPw">비밀번호 확인</label></td>
        <td><input type="password" name="now" id="nowPw" class="mypage-pw-input-red"><input type="submit" value="탈퇴" class="leave-btn"></td>
      </tr>
      <!-- 비밀번호 변경 -->
      <tr id="prePw" class="hidden">
        <td><label for="prePwCh">기존 비밀번호</label></td>
        <td><input type="password" name="pre" id="prePwCh" class="mypage-pw-input"></td>
      </tr>
      <tr id="newPw" class="hidden">
        <td><label for="newPwCh">새 비밀번호</label></td>
        <td><input type="password" name="new" id="newPwCh" class="mypage-pw-input"></td>
      </tr>
      <tr id="checkNewPw" class="hidden">
        <td><label for="checkPwCh">비밀번호 확인</label></td>
        <td><input type="password" id="checkPwCh" class="mypage-pw-input"></td>
      </tr>
    </table>
    <table  class="mypage-table" id="tableBtn">
      <tr id="changePwBtn" class="none on">
        <td>
          <input type="submit" name="button" value="수정">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>
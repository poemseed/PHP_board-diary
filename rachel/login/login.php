<!-- meta가져오기 -->
<?php include "../template/meta.php" ?>
<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include "../template/header.php" ?>
  <h2 id="boardTitle">
    <span class="material-symbols-outlined">password</span>
    로그인
    <span class="material-symbols-outlined">login</span>
  </h2>
  <div id="loginWrap">
    <div>
    <form action="check_login.php" method="post" name="loginForm" onsubmit="doSubmit(); return false;">
      <input type="text" name="id" placeholder="아이디" class="login-form">
      <input type="password" name="pw" placeholder="비밀번호를 입력하세요" class="login-form">
      <input type="submit" name="button" value="로그인" class="login-form button">
    </form>
    <div class="login-form sign-up">
      <p>회원이 아니세요?<a href="join.php">회원가입</a></p>
    </div>
    </div>
  </div>
</body>
</html>
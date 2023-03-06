<!-- meta가져오기 -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>
<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <div class="join-form">
    <form action="join_ok.php" name="joinForm" method="post" onsubmit="return checkJoin()">
      <h2 id="boardTitle">
        <span class="material-symbols-outlined">handshake</span>
        회원가입
        <span class="material-symbols-outlined">celebration</span>
      </h2>
      <div class="join-form">
        <label for="joinId">아이디</label>
        <input type="text" id="joinId" name="id" class="join-input">
      </div>
      <div class="join-form">
        <label for="joinPw1">비밀번호</label>
        <input type="password" id="joinPw1" name="pw" class="join-input">
      </div>
      <div class="join-form">
        <label for="joinPw2">비밀번호 확인</label>
        <input type="password" id="joinPw2" class="join-input">
      </div>
      <div class="join-form">
        <label for="joinName">이름</label>
        <input type="text" id="joinName" name="userName" class="join-input">
      </div>
      <input type="submit" name="button" value="회원가입" class="join-input join-btn button">
    </form>
  </div>
</body>
</html>
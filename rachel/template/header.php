<header id="header">
  <h1>
    <a href="/rachel/index.php?page=1">
      <span class="material-symbols-outlined">icecream</span>
    </a>
  </h1>
  <nav id="member">
    <ul>
      <?php if(isset($_SESSION['userId'])){  ?>
      <li class="user-name"><?php echo "Hi, $username"; ?></li>
      <li><a href="/rachel/mypage/mypage.php">내정보</a></li>
      <li><a href="/rachel/login/logout.php">로그아웃</a></li>
      <?php }else{ ?>
      <li><a href="/rachel/login/login.php">로그인</a></li>
      <li><a href="/rachel/login/join.php">회원가입</a></li>
      <?php } ?>
    </ul>
  </nav>
  <a href="#" id="gnbView">menu</a>
  <nav id="gnb">
    <ul>
      <li><a href="/rachel/index.php?page=1">게시판</a></li>
      <!-- 로그인 여부에 따라서 일기장 메뉴 버튼 다르게 반응 -->
      <?php if(isset($_SESSION['userId'])){  ?>
        <li><a href="/rachel/diary/diary.php">일기장</a></li>
      <?php }else{ ?>
        <li><a href="javascript:plzLogin()">일기장</a></li>
      <?php } ?>
    </ul>
  </nav>
</header>
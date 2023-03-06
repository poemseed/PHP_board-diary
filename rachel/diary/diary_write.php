<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php"; ?>
<!-- meta가져오기(네비에 사용되는 세션에 저장된userId 소스 포함) -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>

<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <!-- 게시판 타이틀 -->
  <h2 id="boardTitle">
    <span class="material-symbols-outlined">draw</span>
    일기장
    <span class="material-symbols-outlined">menu_book</span>
  </h2>
  <div>
    <form action="/rachel/diary/diary_proc.php" method="post" name="diaryUploadForm" enctype="multipart/form-data">
      <input type="hidden" name="mode" value="N"> 
      <table>
        <tr style="display:none">
          <th class="width-150">글쓴이</th>
          <td>
            <input name="id" value="<?php echo $userid ?>" readonly>
          </td>
        </tr>
        <tr style="display:none">
          <th class="width-150">날짜</th>
          <td>
            <input name="date" value="<?php echo $_GET['date'] ?>" readonly>
          </td>
        </tr>
        <tr>
          <th class="width-150">내용</th>
          <td style="height: 600px;" class="text-align-left">
            <textarea name="content" class="diary-content" maxlength="2500"></textarea>
          </td>
        </tr>
        <tr>
          <th>파일</th>
          <td>
            <input type="file" name="upfile" id="upfile" accept="image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
          </td>
        </tr>
      </table>
      <table class="margin-top-30">
        <tr class="text-align-right">
          <td>
            <a href="javascript:checkDiary()">등록</a>
            <a href="/rachel/diary/diary.php">목록</a>
          </td>
        </tr>
      </table>
    </form>
  </div>

</body>
</html>
<?php 
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";

  $bno = $_GET['idx'];
  $sql = query("select * from board where idx='$bno';");
  $board = $sql->fetch_array();
?>
<!-- meta가져오기 -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>
<!-- editor가져오기 -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/editor.php" ?>
<body onload="initEditor();">
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <h2 id="boardTitle">
    <span class="material-symbols-outlined">attractions</span>
    게시판
    <span class="material-symbols-outlined">festival</span>
  </h2>
  <div>
    <form action="proc.php?idx=<?php echo $bno ?>&page=<?php echo $_GET['page'] ?>" method="post" name="boardForm">
      <input type="hidden" name="mode" value="U">
      <table>
        <tr>
          <th class="width-150">제목</th>
          <td>
            <input name="title" size="50" maxlength="100" placeholder="제목을 입력하세요" value="<?php echo $board['title'] ?>">
          </td>
        </tr>
        <tr style="display:none;">
          <th class="width-150">글쓴이</th>
          <td>
            <input name="id" value="<?php echo $board['id'] ?>">
          </td>
        </tr>
        <tr>
          <th class="width-150">내용</th>
          <td style="height: 600px;" class="text-align-left">
            <textarea name="content" id="synapEditor">
              <?php echo $board['content'] ?>
            </textarea>
          </td>
        </tr>
      </table>
      <table class="margin-top-30">
        <tr class="text-align-right">
          <td>
            <a href="javascript:checkBoard()">수정</a>
            <a href="/rachel/index.php?page=<?php echo $_GET['page'] ?>">목록</a>
          </td>
        </tr>
      </table>
    </form>
  </div>
</body>
</html>
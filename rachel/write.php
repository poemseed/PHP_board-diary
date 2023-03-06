<?php session_start(); ?>
<!-- meta가져오기 -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>
<!-- editor가져오기 -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/editor.php" ?>
<body onload="initEditor();">
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <div>
    <h2 id="boardTitle">
      <span class="material-symbols-outlined">attractions</span>
      게시판
      <span class="material-symbols-outlined">festival</span>
    </h2>
    <div>
      <form action="/rachel/proc.php" method="post" name="boardForm">
        <input type="hidden" name="mode" value="N"> 
        <table>
          <tr>
            <th class="width-150">제목</th>
            <td>
              <input name="title" size="50" maxlength="80" placeholder="제목을 입력하세요">
            </td>
          </tr>
          <tr style="display:none;">
            <th class="width-150">글쓴이</th>
            <td>
              <input name="id" value="<?php echo $userid ?>" readonly>
            </td>
          </tr>
          <tr>
            <th class="width-150">내용</th>
            <td style="height: 600px;" class="text-align-left">
              <textarea name="content" id="synapEditor"></textarea>
            </td>
          </tr>
        </table>
        <table class="margin-top-30">
          <tr class="text-align-right">
            <td>
              <a href="javascript:checkBoard()">등록</a>
              <a href="/rachel/index.php?page=1">목록</a>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</body>
  
</html>
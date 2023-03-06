<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php"; ?>
<!-- meta가져오기(네비에 사용되는 세션에 저장된userId 소스 포함) -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>
<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <?php
    $bno = $_GET['idx'];

    // 글 조회수 늘이기(본인글은 올라가지 않음)
    $hit = mysqli_fetch_array(query("select * from board where idx ='".$bno."'"));
    if( $userid != $hit['id']){
      $hit = $hit['hits'] + 1;
      $fet = query("update board set hits = '".$hit."' where idx ='".$bno."'");
    }

    $sql = query("select * from board where idx ='".$bno."'");
    $board = $sql->fetch_array();
  ?>
  <!-- 글 불러오기 -->
  <h2 id="boardTitle">
    <span class="material-symbols-outlined">attractions</span>
    게시판
    <span class="material-symbols-outlined">festival</span>
  </h2>
  <table class="table-layout">
    <tr>
      <th class="width-150">제목</th>
      <td class="text-align-left">
        <!-- 제목 date -->
        <?php echo $board['title']; ?>
        <!-- 날짜 date , 조회수 date-->
        <span class="float">
          날짜 : <?php echo $board['date'] ?> | 조회수 : <?php echo $board['hits']; ?>
        </span>
      </td>
    </tr>
    <tr>
      <th class="width-150">글쓴이</th>
      <td class="text-align-left">
        <!-- 글쓴이 date -->
        <?php echo $board['id']; ?>
      </td>
    </tr>
    <tr>
      <th class="width-150">내용</th>
      <td class="text-align-left word-wrap">
        <!-- 내용 date -->
        <?php echo $board['content']; ?>
      </td>
    </tr>
  </table>
  <br>
  <table>
    <tr class="text-align-right">
      <?php if( $userid == $board['id'] ){ ?>
        <td class="padding-10">
          <a href="/rachel/modify.php?idx=<?php echo $board['idx']; ?>&page=<?php echo $_GET['page'] ?>">수정</a>
          <a href="/rachel/proc.php?idx=<?php echo $board['idx']; ?>&page=<?php echo $_GET['page'] ?>">삭제</a>
          <!-- <a href="index.php?page=<?php echo $_GET['page'] ?>">목록</a> -->
          <a href="javascript:boardList()">목록</a>
        </td>
      <?php }else{ ?>
        <td class="padding-10">
          <a href="javascript:boardList()">목록</a>
        </td>
      <?php } ?>
    </tr>
  </table>
  <br>
<!-- 댓글기능 -->
  <!-- 댓글입력 -->
  <br>
  <form action="/rachel/reply.php?idx=<?php echo $bno; ?>&page=<?php echo $_GET['page'] ?>&mode=N" method="post" name="replyForm">
    <input type="hidden" name="idx" value="<?php echo $bno; ?>">
    <table>
      <tr>
        <td style="display:none;">
          <input class="width-200" name="id" value="<?php echo $userid ?>" readonly><br>
        </td>
        <td class="reply-icon">
        <span class="material-symbols-outlined">rocket_launch</span>
        </td>
        <td class="text-align-left position">
          <textarea name="content" id="replyContent" class="replyWrite" maxlength="200"></textarea>
          <!-- <a href="javascript:document.replyForm.submit()" class="">등록</a> -->
          <a href="javascript:replyInsert()" class="">등록</a>
        </td>
      </tr>
    </table>
    
    <br><br>
    <!-- 댓글목록 -->
    <?php
      $sql3 = query("select * from reply where boardIdx='".$bno."' order by replyIdx desc");

      $result = mysqli_num_rows($sql3);
      
      if($result != 0 ){
        while($reply = $sql3->fetch_array()){
    ?>
    <table class="replyBox">
      <tr>
        <td class="replyId"><?php echo $reply['id'] ?></td>
        <td class="replyCon">
          <textarea id="reply<?php echo $reply['replyIdx'] ?>" class="reply" name="reply<?php echo $reply['replyIdx'] ?>" readonly maxlength="200"><?php echo $reply['content'] ?></textarea><br>
        </td>
        <td class="replyDate"><?php echo $reply['date'] ?></td>
        <?php if( $userid == $reply['id']){ ?>
          <td class="replyBtn">
            <!-- 수정하기를 누르면 readonly가 사라져서 내용수정가능 -->
            <a href="javascript:updateReadonlyReply(<?php echo $reply['replyIdx'] ?>, '<?php echo $reply['content'] ?>')" class="activeReply">수정하기</a>
            <a href="javascript:updateReply(<?php echo $reply['replyIdx'] ?>)">수정</a>
            <a href="javascript:deleteReply(<?php echo $reply['replyIdx'] ?>)">삭제</a>
          </td>
        <?php } ?>
      </tr>
    </table>
    <?php } } ?>
    
    </form>

</body>
</html>
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php"; ?>
<!-- meta가져오기(네비에 사용되는 세션에 저장된userId 소스 포함) -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>

<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <?php 
    // $sql = query("SELECT * FROM diary d LEFT OUTER JOIN diaryFile df ON d.diaryIdx = df.diaryIdx WHERE d.id='".$userid."' AND d.date = '".$_GET['date']."'");

    $sql = query("SELECT * FROM diary d LEFT OUTER JOIN diaryFile df ON d.diaryIdx = df.diaryIdx WHERE d.diaryIdx='".$_GET['diaryIdx']."'");
    $diary = $sql->fetch_array();

    // 날짜 년월일로 나누기
    $diary_date_arr = explode("-",$diary['date']);
    // 이미지파일
    $imgext = array('jpg','gif','png','jpeg','bmp');
    // 확장자
    $ext = explode('.',$diary['nameSave']);
    $ext = strtolower(array_pop($ext));
  ?>
  <!-- 게시판 타이틀 -->
  <h2 id="boardTitle">
    <span class="material-symbols-outlined">draw</span>
    일기장
    <span class="material-symbols-outlined">menu_book</span>
  </h2>
  <div>
    <table class="table-layout">
      <tr>
        <th class="width-150">날짜</th>
        <td class="text-align-left">
          <!-- 날짜 -->
          <!-- <?php echo $diary['date']; ?> -->
          <?php echo $diary_date_arr[0] ?>년 <?php echo $diary_date_arr[1] ?>월 <?php echo $diary_date_arr[2] ?>일
        </td>
      </tr>
      <tr  style="display:none">
        <th class="width-150">글쓴이</th>
        <td class="text-align-left">
          <!-- 글쓴이 -->
          <?php echo $diary['id']; ?>
        </td>
      </tr>
      <tr>
        <th class="width-150">내용</th>
        <td class="text-align-left word-wrap">
          <!-- 내용-->
          <?php echo $diary['content']; ?>
        </td>
      </tr>
      <!-- 첨부파일이 사진이면 보여주기 -->
      <?php if(in_array($ext,$imgext)){ ?>
      <tr>
        <th class="width-150"></th>
        <td class="text-align-left word-wrap">
          <!-- 사진-->
          <img class="img-view" src="../uploads/diary/<?=$diary['nameSave'];?>">
        </td>
      </tr>
      <?php } ?>
      <!-- 파일있다면 -->
      <?php if($diary['nameOrig']){ ?>
        <tr>
          <th class="width-150">다운로드</th>
          <td class="text-align-left word-wrap">
            <!-- 파일 -->
            <a href="../uploads/diary/<?=$diary['nameSave'];?>"download><?php echo $diary['nameOrig']; ?></a>
          </td>
        </tr>
      <?php }else{?>  <!-- 파일없다면 -->
        <tr>
          <th class="width-150">첨부파일</th>
          <td class="text-align-left word-wrap">
            없음
          </td>
        </tr>
      <?php }?>
    </table>
    <br>
    <table>
    
    <tr class="text-align-right">
      <td class="padding-10">
        <a href="/rachel/diary/diary_modify.php?diaryIdx=<?php echo $_GET['diaryIdx'] ?>">수정</a>
        <a href="/rachel/diary/diary_proc.php?diaryIdx=<?php echo $_GET['diaryIdx'] ?>">삭제</a>
        <a href="/rachel/diary/diary.php">목록</a>
      </td>
    </tr>
  </table>
  </div>
</body>
</html>
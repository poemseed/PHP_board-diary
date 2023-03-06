<?php 
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php"; 

  $dno = $_GET['diaryIdx'];

  $sql = query("SELECT * FROM diary d LEFT OUTER JOIN diaryFile df ON d.diaryIdx = df.diaryIdx WHERE d.diaryIdx='".$dno."'");
  $diary = $sql->fetch_array();
?>
<!-- meta가져오기(네비에 사용되는 세션에 저장된userId 소스 포함) -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>
<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <form action="/rachel/diary/diary_proc.php?diaryIdx=<?php echo $dno; ?>" method="post" name="diaryUploadForm" enctype="multipart/form-data">
      <input type="hidden" name="mode" value="U"> 
      <table>
        <tr style="display:none">
          <th class="width-150">글쓴이</th>
          <td>
            <input name="id" value="<?php echo $diary['id'] ?>" readonly>
          </td>
        </tr>
        <tr style="display:none">
          <th class="width-150">날짜</th>
          <td>
            <input name="date" value="<?php echo $diary['date'] ?>" readonly>
          </td>
        </tr>
        <tr>
          <th class="width-150">내용</th>
          <td style="height: 600px;" class="text-align-left">
            <textarea name="content" class="diary-content" maxlength="2500"><?php echo $diary['content'] ?></textarea>
          </td>
        </tr>
        <tr>
          <th>파일</th>
          <td>
            <!-- 저장된 파일이 없다면 -->
            <?php if(!$diary['nameSave']){ ?>
              <input type="hidden" name="is_file" value="NF">
              <input type="hidden" name="new_file" value="off" id="newfile">
              <input type="file" name="upfile" id="upfile" accept="image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
            <?php }else{ ?> <!-- 저장된 파일이 있다면 -->
              <input type="hidden" name="is_file" value="YF">
              <input type="hidden" name="change_file" value="off" id="change_file">
              <input type="hidden" name="upfile" id="upfile" accept="image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
              <div id="preFile">
                <p><?php echo $diary['nameOrig'] ?>
                <a href="javascript:void(0);" id="deleteBtn" onclick="delBinBnt();">
                  <span class="material-symbols-outlined">delete</span>
                </a>
                </p>
              </div>
            <?php } ?>
          </td>
        </tr>
      </table>
      <table class="margin-top-30">
        <tr class="text-align-right">
          <td>
            <!-- 저장된 파일이 없다면 -->
            <?php if(!$diary['nameSave']){ ?>
              <a href="javascript:checkDiaryfile()">수정</a>
            <?php }else{ ?> <!-- 저장된 파일이 있다면 -->
              <a href="javascript:checkDiaryfileUp()">수정</a>
            <?php } ?>
            <a href="javascript:history.back()">취소</a>
          </td>
        </tr>
      </table>
    </form>
  </div>

</body>
</html>
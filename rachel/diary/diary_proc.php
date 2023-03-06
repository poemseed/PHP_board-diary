<?php
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";
  date_default_timezone_set('Asia/Seoul');

  // 한페이지에서 쓰기, 수정, 삭제 수행하기 위해 받아온 값
  $mode = (isset($_POST['mode']))       ? $_POST['mode'] :"";

  $id = (isset($_POST['id']))           ? $_POST['id'] :"";
  $content = (isset($_POST['content'])) ? $_POST['content'] :"";
  $date = (isset($_POST['date']))       ? $_POST['date']  :"";
  $file = (isset($_FILES['upfile']))    ?$_FILES['upfile']:"";
 
  // 수정,삭제
  $diaryIdx = (isset($_GET['diaryIdx']))        ?$_GET['diaryIdx']:"";
  $is_file = (isset($_POST['is_file']))         ?$_POST['is_file']:"";
  $new_file = (isset($_POST['new_file']))       ?$_POST['new_file']:"";
  $change_file = (isset($_POST['change_file'])) ?$_POST['change_file']:"";

  // 일기 쓰기
  if($mode == "N"){
    // 파일 형식과 용량 체크하기
    include_once $_SERVER['DOCUMENT_ROOT']."/rachel/template/file_check.php";

    // diary 테이블 입력
    $mqq = query("alter table diary auto_increment = 1");
    $sql = query("insert into diary(content, id, date) values('".$content."','".$id."','".$date."')");
    // diary 테이블 인덱스번호 가져오기
    $last_uid = mysqli_insert_id($db);
    echo $last_uid;
    
    // diaryFile 테이블 입력
    if( $name ){  // 파일이 있는경우
      $mqq = query("alter table diaryFile auto_increment = 1");
      $sql = query("insert into diaryFile(nameOrig, nameSave, diaryIdx) values('".$name."','".$savename."','".$last_uid."')");
      echo "<script>alert('[파일있음] 일기쓰기가 완료되었습니다.');
            location.href='/rachel/diary/diary.php';</script>";
    }else if( !$name ){ // 파일이 없는경우
      echo "<script>
      alert('[파일없음] 일기쓰기가 완료되었습니다.');
      location.href='/rachel/diary/diary.php';</script>";
    }else{
      echo "<script>
      alert('일기쓰기에 실패했습니다.');
      history.back();</script>";
    }

  }else if($mode == "U"){ // 일기 수정
    // 1.저장된 파일이 없는 상태에서 수정했을때
    if( $is_file == "NF" ){  
      if( $new_file == "on" ){  // 새롭게 파일을 추가
        
        // 파일 형식과 용량 체크하기
        include_once $_SERVER['DOCUMENT_ROOT']."/rachel/template/file_check.php";
        
        // diary 테이블 업데이트
        $sql = query("update diary set content='".$content."' where diaryIdx='".$diaryIdx."'");
        $mqq = query("alter table diaryFile auto_increment = 1");
        $sql2 = query("insert into diaryFile(nameOrig, nameSave, diaryIdx) values('".$name."','".$savename."','".$diaryIdx."')");

        echo "<script>alert('[파일있음] 일기수정이 완료되었습니다.');
            location.href='/rachel/diary/diary_read.php?diaryIdx=$diaryIdx';</script>";
      
      }else if($new_file == "off"){
        $sql = query("update diary set content='".$content."' where diaryIdx='".$diaryIdx."'");
        echo "<script>alert('[파일없음] 일기수정이 완료되었습니다.');
            location.href='/rachel/diary/diary_read.php?diaryIdx=$diaryIdx';</script>";
      }else{
        echo "<script>
        alert('일기 수정에 실패했습니다.');
        history.back();</script>";
      }

    }else if( $is_file == "YF" ){ // 2.저장된 파일이 있는 상태에서 수정했을때
      // 저장된 파일 변경(기존 파일 삭제하고 새로운 파일 업로드)
      if( $change_file == "on" ){
        $sql1 = query("SELECT * FROM diary d LEFT OUTER JOIN diaryFile df ON d.diaryIdx = df.diaryIdx WHERE d.diaryIdx='".$diaryIdx."'");
        $diary = $sql1->fetch_array();
        // 기존 파일 삭제
        if( is_file( '../uploads/diary/'.$diary['nameSave'] ) == true ) {
          unlink("../uploads/diary/".$diary['nameSave']);
        }
        // 파일 형식과 용량 체크하기
        include_once $_SERVER['DOCUMENT_ROOT']."/rachel/template/file_check.php";

        // diary, diaryFile 테이블 업데이트
        $sql = query("update diary set content='".$content."' where diaryIdx='".$diaryIdx."'");
        $sql2 = query("update diaryFile set nameOrig='".$name."',nameSave='".$savename."' where diaryIdx='".$diaryIdx."'");

        echo "<script>alert('[파일변경] 일기수정이 완료되었습니다.');
            location.href='/rachel/diary/diary_read.php?diaryIdx=$diaryIdx';</script>";

      }else if($change_file == "off"){  // 파일 그대로인 상태에서 수정했을때
        // 파일 있고 글만 수정
        // diary 테이블 업데이트
        $sql = query("update diary set content='".$content."' where diaryIdx='".$diaryIdx."'");

        echo "<script>alert('[파일있음] 일기수정이 완료되었습니다.');
            location.href='/rachel/diary/diary_read.php?diaryIdx=$diaryIdx';</script>";

        
      }else if( $change_file == "del" ){  // 기존 파일 삭제 수정 (새로운 파일 업로드X)
        $sql1 = query("SELECT * FROM diary d LEFT OUTER JOIN diaryFile df ON d.diaryIdx = df.diaryIdx WHERE d.diaryIdx='".$diaryIdx."'");
        $diary = $sql1->fetch_array();
        // 기존 파일 삭제
        if( is_file( '../uploads/diary/'.$diary['nameSave'] ) == true ) {
          
          unlink("../uploads/diary/".$diary['nameSave']);
        }
        // diaryFile 데이터 삭제
        $sql2 = query("delete from diaryFile where diaryIdx='$diaryIdx';");
        // diary 테이블 업데이트
        $sql = query("update diary set content='".$content."' where diaryIdx='".$diaryIdx."'");

        echo "<script>alert('[파일삭제] 일기수정이 완료되었습니다.');
            location.href='/rachel/diary/diary_read.php?diaryIdx=$diaryIdx';</script>";

      }else{
        echo "<script>
        alert('일기 수정에 실패했습니다.');
        history.back();</script>";
      }



    }



  }else{  // 삭제
    $sql1 = query("SELECT * FROM diary d LEFT OUTER JOIN diaryFile df ON d.diaryIdx = df.diaryIdx WHERE d.diaryIdx='".$diaryIdx."'");
    $diary = $sql1->fetch_array();

    // 저장된 파일이 있는 일기일때 파일삭제
    if( is_file( '../uploads/diary/'.$diary['nameSave'] ) == true ) {
      unlink("../uploads/diary/".$diary['nameSave']);
    }

    $sql = query("delete from diary where diaryIdx='$diaryIdx';");

    echo "<script>alert('일기가 삭제되었습니다.');
    location.href='/rachel/diary/diary.php';</script>";


  }  

?>
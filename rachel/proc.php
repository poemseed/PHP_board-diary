<?php
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";
  date_default_timezone_set('Asia/Seoul');
  
  // 한페이지에서 쓰기, 수정, 삭제 수행하기 위해 받아온 값
  $mode = (isset($_POST['mode']))       ? $_POST['mode'] :"";

  $id = (isset($_POST['id']))           ? $_POST['id'] :"";
  $title = (isset($_POST['title']))     ? $_POST['title'] :"";
  $content = (isset($_POST['content'])) ? $_POST['content'] :"";
  $date = date('Y-m-d');

  $bno = (isset($_GET['idx']))          ? $_GET['idx'] : "";

  // 글쓰기
  if($mode == "N"){
    if( $id && $title && $content ){
      // 최근글 삭제 후 다시 글쓰면 자동시퀀스 번호 삭제된 글 번호로 시작하기
      $mqq = query("alter table board auto_increment = 1");
      $sql = query("insert into board(title, content, id, date, hits) values('".$title."','".$content."','".$id."','".$date."', 0)");
      echo "<script>
      alert('글쓰기가 완료되었습니다.');
      location.href='/rachel/index.php?page=1';</script>";
    }else{
      echo "<script>
      alert('글쓰기에 실패했습니다.');
      history.back();</script>";
    }

  }else if($mode == "U"){ //글 수정
    $sql = query("update board set id='".$id."',title='".$title."',content='".$content."',date='".$date."' where idx='".$bno."'");
    
    echo "<script type='text/javascript'>
    const urlParams = new URL(location.href).searchParams;
    const idx = urlParams.get('idx');
    const page = urlParams.get('page');

    alert('수정되었습니다.');
    location.replace('/rachel/read.php?idx='+idx+'&page='+page);
    </script>";

  }else{ //글 삭제
    $sql = query("delete from board where idx='$bno';");

    echo "<script type='text/javascript'>
    const urlParams = new URL(location.href).searchParams;
    const page = urlParams.get('page');

    alert('삭제되었습니다.');
    location.replace('/rachel/index.php?page='+page);
    </script>";
  }
?>
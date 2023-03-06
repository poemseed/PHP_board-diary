<?php
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";
  date_default_timezone_set('Asia/Seoul');
  // 여기서 쓰기, 수정, 삭제 수행 위해 get방식으로 값 받아옴
  $mode = (isset($_GET['mode']))    ? $_GET['mode'] :"";

  // 쓰기 관련
  $bno = (isset($_GET['idx']))      ? $_GET['idx']  :"";
  $date = date('Y-m-d');
  $page = (isset($_GET['page']))    ? $_GET['page'] :"";

  // 수정, 삭제관련
  $rno = (isset($_GET['ridx']))      ? $_GET['ridx']  :"";
  $bno_p = (isset($_POST['idx']))   ? $_POST['idx'] :"";
  // 업데이트 할 댓글내용 name이 reply + 댓글번호로, 유동적
  $content = (isset($_POST['reply'.$rno]))  ? $_POST['reply'.$rno]:"";
  

  // 댓글쓰기
  if($mode == "N"){
    if($bno && $_POST['id'] && $_POST['content']){
      // 최근글 삭제 후 다시 글쓰면 자동시퀀스 번호 삭제된 글 번호로 시작하기
      $mqq = query("alter table reply auto_increment = 1");
      $sql = query("insert into reply(id, content, boardIdx, date) values('".$_POST['id']."','".$_POST['content']."','".$bno."','".$date."')");

      echo "<script>alert('댓글이 작성되었습니다.');
      location.href='/rachel/read.php?idx=$bno&page=$page';</script>";
    }else{
      echo "<script>alert('댓글 작성에 실패했습니다.');
      history.back();</script>";
    }
  }else if($mode == "U"){ //댓글 수정
    $sql = query("update reply set content='".$content."',date='".$date."' where replyIdx = '".$rno."'");

    echo "<script type='text/javascript'>
    const urlParams = new URL(location.href).searchParams;
    const page = urlParams.get('page');
    alert('수정되었습니다.??'); 
    location.replace('/rachel/read.php?idx=$bno_p&page='+ page);</script>";
  }else{  // 댓글 삭제
    $sql = query("delete from reply where replyIdx='".$rno."'" );

    echo "<script type='text/javascript'>

    const urlParams = new URL(location.href).searchParams;
    const page = urlParams.get('page');
  
    alert('댓글이 삭제되었습니다.'); 
    location.replace('/rachel/read.php?idx=$bno_p&page='+ page)</script>";
  }


?>
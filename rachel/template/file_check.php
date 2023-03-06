<?php
$error = $_FILES['upfile']['error'];
$name = $_FILES['upfile']['name'];
$uploads_dir = '../uploads/diary';
$allowed_ext =  array('hwp','xls','doc','xlsx','docx','pdf','jpg','gif','png','jpeg','bmp','txt','ppt','pptx');
//확장자추출
$ext = explode('.',$name); 
$ext = strtolower(array_pop($ext));

// 오류 확인
if( $error != UPLOAD_ERR_OK ) {
  switch( $error ) {
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
      echo "파일이 너무 큽니다. ($error)";
      echo "<script>alert('파일이 너무 큽니다.'); window.history.back()</script>";
      exit;
    //   break;
    // case UPLOAD_ERR_NO_FILE:
    //   echo "파일이 첨부되지 않았습니다. ($error)";
    //   break;
    // default:
    //   echo "파일이 제대로 업로드되지 않았습니다. ($error)";
  }
  // exit;
}

// 확장자 확인
if( $name ){
  if( !in_array($ext, $allowed_ext) ) {
    echo "허용되지 않는 확장자입니다.";
    echo "<script>alert('허용되지않는 확장자입니다.'); window.history.back()</script>";
    exit;
  }
}
// 저장 파일명 (랜덤수_현재시간_랜덤수.파일 확장자) - 파일명 중복될 경우를 대비
$savename = mt_rand(0,99999) . '_' .time() . '_' . mt_rand(0,99999) . '.' . strtolower($ext);

// 디렉토리 여부 확인
$path = '../uploads';
if( !is_dir($path) ){
  mkdir($path);
}

if( !is_dir($uploads_dir) ){
  mkdir($uploads_dir);
}

// 파일 이동후 저장
move_uploaded_file( $_FILES['upfile']['tmp_name'], "$uploads_dir/$savename");
?>
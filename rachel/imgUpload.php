<?php 
    try {
        //업로드 디렉토리
        $uploadDir = './uploads/img';
    
        //폼 데이터 이름
        $fieldName = 'file';
    
        //파일 이름
        $fileName = explode('.', $_FILES[$fieldName]['name']);
    
        //파일 확장자
        $extension = end($fileName);
    
        //임시 파일 이름
        $tmpName = $_FILES[$fieldName]['tmp_name'];
    
        //저장될 새로운 파일이름
        $newFileName = sha1(microtime());
    
        //실제 파일 업로드 경로
        $fileUploadPath = "${uploadDir}/${newFileName}.${extension}";
    
        //파일을 저장합니다
        move_uploaded_file($tmpName, $fileUploadPath);
    
        //클라이언트로 응답을 보냅니다.
        header('Content-Type: application/json');
        echo json_encode(array(
            'uploadPath' => $fileUploadPath,
        ));
    
    } catch (Exception $e) {
        echo $e->getMessage();
        http_response_code(404);
    }
?>
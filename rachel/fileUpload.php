<?php
try {
    // upload path
    $uploadDir = 'c:/APM/rookies/rachel/uploads/files';
 
 
    // form filed name
    $fieldName = 'file';
 
    // file name
    $fileName = explode('.', $_FILES[$fieldName]['name']);
 
    //file extension
    $extension = end($fileName);
 
    // temp file name
    $tmpName = $_FILES[$fieldName]['tmp_name'];
 
    // new file name to save
    $newFileName = sha1(microtime());
 
    // file upload path
    $fileUploadPath = "${uploadDir}/${newFileName}.${extension}";
 
    // save file to disk
    move_uploaded_file($tmpName, $fileUploadPath);
 
    // directory name to save conversion result
    $wordDir = 'works';
 
    // execute conversion
    $importPath = "${wordDir}/${newFileName}";
    executeConverter($fileUploadPath, $importPath);
 
    // serialize document data
    // v2.3.0 부터 파일명이 document.word.pb에서 document.pb로 변경됨
    $pbFilePath = "${importPath}/document.pb";
    $serializedData = readPBData($pbFilePath);
 
    // send response
    header('Content-Type: application/json');
    echo json_encode(array(
        'serializedData' => $serializedData,
        'importPath' => $importPath,
    ));
 
} catch (Exception $e) {
    echo $e->getMessage();
    http_response_code(404);
}
 
function executeConverter($inputFilePath, $outputFilePath)
{
    $sedocConverterPath = 'C:/APM/rookies/rachel/SynapEditorPackage/sedocConverter/windows/sedocConverter.exe';
    $fontsDir = 'c:/sedocConverter/fonts';
    $tempDir = 'c:/sedocConverter/tmp';
 
    $cmd = "${sedocConverterPath} -f ${fontsDir} ${inputFilePath} ${outputFilePath} ${tempDir}";
    exec($cmd);
}
 
 
function readPBData($pbFilePath)
{
    $fb = fopen($pbFilePath, 'r');
    $data = stream_get_contents($fb, -1, 16);
    fclose($fb);
 
    $byteArray = unpack('C*', zlib_decode($data));
    // php 5.4.0 미만
    // $byteArray = unpack('C*', gzuncompress($data));
    $serializedData = array_values($byteArray);
 
    return $serializedData;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>게시판</title>
  <link rel="stylesheet" type="text/css" href="/rachel/css/style.css?after">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <script type="text/javascript" src="/rachel/js/common.js"></script>
</head>
<!-- 로그인관련 -->
<?php
  // session_start();
  if(isset($_SESSION['userName'])){
    $username = $_SESSION['userName'];
    $userid = $_SESSION['userId'];
    $useridx = $_SESSION['userIdx'];
  }
?>
<?php  
  include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php";
?>
<!-- meta가져오기 -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>
<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <?php 
    // 검색변수
    $catagory = $_GET['catgo'];
    $search_con = $_GET['search'];

    if($catagory=='title'){
      $catname = '제목';
    }else if($catagory=='id'){
      $catname = '작성자';
    }else if($catagory == 'content'){
      $catname = '내용';
    }
  ?>
  <div id="search">
  <h2>
    <span class="material-symbols-outlined">manage_search</span>검색
    <span>
      <?php echo $catname; ?> : <?php echo $search_con; ?>
    </span> 
  </h2>
  <!-- <h4 class="margin-top-30">
    <a href="/rachel/index.php?page=1" class="go-back">돌아가기</a>
  </h4> -->
  <?php 
    $sql2 = query("select * from board where $catagory like '%$search_con%' order by idx desc");
    // 검색결과가 있으면 table 나옴
    if($sql2->num_rows > 0){ 
  ?>
  <table>
    <thead>
      <tr>
        <th class="boardNum">번호</th>
        <th class="boardTitle">제목</th>
        <th class="writer">글쓴이</th>
        <th class="date">작성일</th>
        <th class="hits">조회수</th>
      </tr>
    </thead>
    <?php
      }else{ echo "<p class='no-search'>검색 결과가 없습니다.</p>";}

      while($board = $sql2->fetch_array()){
        $title = $board['title'];
        
        if(strlen($title) > 30){
          $title = str_replace($board['title'],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
        }
        $sql3 = query("select * from reply where replyIdx='".$board['idx']."'");
        $rep_count = mysqli_num_rows($sql3);
        
        
    ?>
    <tbody>
      <tr class="search-result">
        <td><?php echo $board['idx']; ?></td>
        <td>
          <a href="/rachel/read.php?idx=<?php echo $board["idx"]; ?>"><?php echo $title; ?><span>[<?php echo $rep_count; ?>]</span></a>
        </td>
        <td><?php echo $board['id'] ?></td>
        <td><?php echo $board['date'] ?></td>
        <td><?php echo $board['hits'] ?></td>
      </tr>
    </tbody>
    <?php } ?>
  </table>
  <form action="/rachel/search_result.php" method="get" class="search-bottom">
    <select name="catgo">
      <option value="title">제목</option>
      <option value="id">글쓴이</option>
      <option value="content">내용</option>
    </select>
    <input type="text" name="search" size="40" required="required" class="search-bottom-input">
    <button>검색</button>
  </form>
  </div>
</body>
</html>
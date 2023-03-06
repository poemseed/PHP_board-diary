<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php"; ?>
<!-- meta가져오기(네비에 사용되는 세션에 저장된userId 소스 포함) -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>

<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <!-- 게시판 타이틀 -->
  <h2 id="boardTitle">
    <span class="material-symbols-outlined">attractions</span>
    게시판
    <span class="material-symbols-outlined">festival</span>
  </h2>
  <!-- 검색 -->
  <form action="/rachel/search_result.php" method="get" name="searchForm" class="search">
    <select name="catgo">
      <option value="title">제목</option>
      <option value="id">글쓴이</option>
      <option value="content">내용</option>
    </select>
    <input type="text" name="search" size="40" required="required" class="search-input">
    <button>검색</button>
  </form>

  <table class="border-list">
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
      //페이징 처리하기
        if(isset($_GET['page'])){
          $page = $_GET['page'];
        }else{
          $page = 1;
        }

        $sql = query("select * from board");
        

        // 게시판 총 레코드 수
        $row_num = mysqli_num_rows($sql);
      
        // 한 페이지에 보여줄 개수
        $list = 10;
        
        // 블록당 보여줄 페이지 개수
        $block_ct = 5;
        
        // 현재 페이지 블록 구하기
        $block_num = ceil($page/$block_ct);
        
        // 블록의 시작 번호
        $block_start = (($block_num - 1) * $block_ct) + 1;
        
        // 블록의 마지막 번호
        $block_end = $block_start + $block_ct - 1;
        
        // 페이징한 페이지 수 구하기
        $total_page = ceil($row_num / $list);
        
        // 블록의 마지막 번호가 페이지수보다 많으면 마지막번호가 페이지수
        if($block_end > $total_page) $block_end = $total_page;
        
        // 블럭 총 개수
        $total_block = ceil($total_page/$block_ct);
        
        // 시작번호 
        $start_num = ($page - 1) * $list;
        
        //board 테이블에서 idx을 기준으로 내림차순으로 10개까지 표시하기
        //$sql = query("select*from board order by idx desc limit 0,10");
        $sql2 = query("select * from board order by idx desc limit $start_num, $list");

        while($board = $sql2->fetch_array()){
          //title 변수에 db에서 가져온 title 선택
          $title = $board["title"];

          if(strlen($title) > 30){
            //title이 30을 넘으면 ..표시
            $title = str_replace($board["title"], mb_substr($board["title"],0,30,"utf-8")."...", $board["title"]);
          }
          
          // 현재페이지 url page=숫자 부분 받아오기
          $nowPage = $_SERVER['QUERY_STRING'];

          //게시글 옆에 댓글 수 넣기
          $con_idx = $board['idx'];
          $reply_count = query("select count(*) as cnt from reply where boardIdx = $con_idx");
  
          if($reply_count){
          $con_reply_count = $reply_count->fetch_array();
          }
    ?>

    <tbody>
      <tr>
        <td><?php echo $board['idx']; ?></td>
        <?php 
          // 새글일때 new mark 표시하기
          $boardtime = $board['date']; // 글쓴 날짜
          $timenow = date("Y-m-d"); // 현재 날짜

          if($boardtime == $timenow){
            $newmark = "<span class='material-symbols-outlined new-mark'>fiber_new</span>";
          }else{
            $newmark = "";
          }
        ?>
        <!-- 로그인 여부에 따라서 글내용 클릭시 다르게 반응 -->
        <?php if(isset($_SESSION['userId'])){  ?>
        <td>
          <a href="/rachel/read.php?idx=<?php echo $board["idx"]; ?>&<?php echo $nowPage ?>">
            <?php 
              if($reply_count){
              echo $title."[".$con_reply_count["cnt"]."]", $newmark; 
              }else{
                echo $title, $newmark;
              }
            ?>
          </a>
        </td>
        <?php }else{ ?>
          <td>
            <a href="javascript:plzLogin()">
              <?php 
                if($reply_count){
                echo $title."[".$con_reply_count["cnt"]."]", $newmark; 
                }else{
                  echo $title, $newmark;
                }
              ?>
            </a>
          </td>
        <?php } ?>
        <td><?php echo $board['id']; ?></td>
        <td><?php echo $board['date']; ?></td>
        <td><?php echo $board['hits']; ?></td>
        </tr>
    </tbody>
    <?php } ?>
  </table>

  <!-- 페이징 처리 -->
  <table class="margin-top-30">
    <tr>
      <td>
        <?php 
          if($page > 1){
            // 처음페이지로 이동
            // 현재페이지에서 이전버튼을 누르면 이전페이지로 이동
            $pre = $page - 1;
            echo "<a href='?page=1'>&nbsp;&nbsp;&laquo;&nbsp;&nbsp;</a><a href='?page=$pre'>&nbsp;&nbsp;&lt;&nbsp;&nbsp;</a>";
          }

          for( $i=$block_start; $i<=$block_end; $i++ ){
            if($page == $i){
              // 현재 페이지는 a태그 제거
              echo "<span class='pagination'>&nbsp;&nbsp;$i&nbsp;&nbsp;</span>";
            }else{
              echo "<a href='?page=$i'>&nbsp;&nbsp;$i&nbsp;&nbsp;</a>";
            }
          }
          
          if($page < $total_page){
            // 현재 페이지에서 다음버튼을 누르면 다음페이지로 이동
            // 마지막페이지로 이동
            $next = $page + 1;
            echo "<a href='?page=$next'>&nbsp;&nbsp;&gt;&nbsp;&nbsp;</a><a href='?page=$total_page'>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;</a>";
          }
        ?>
      </td>
    </tr>
  </table>

  <!-- 글쓰기 버튼 -->
  <table class="margin-top-20">
    <tr class="text-align-right">
      <!-- 로그인 여부에 따라서 글쓰기 버튼 다르게 반응 -->
      <?php if(isset($_SESSION['userId'])){  ?>
        <td><a href="/rachel/write.php">글쓰기</a></td>
      <?php }else{ ?>
        <td><a href="javascript:plzLogin()">글쓰기</a></td>
      <?php } ?>
    </tr>
  </table>
</body>
</html>
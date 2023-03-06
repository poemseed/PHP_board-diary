<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/db.php"; ?>
<!-- meta가져오기(네비에 사용되는 세션에 저장된userId 소스 포함) -->
<?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/meta.php" ?>
<!-- 달력 -->
<?php
//---- 오늘 날짜
$thisyear = date('Y'); // 4자리 연도
$thismonth = date('n'); // 0을 포함하지 않는 월
$today = date('j'); // 0을 포함하지 않는 일
//------ $year, $month 값이 없으면 현재 날짜
$year = isset($_GET['year']) ? $_GET['year'] : $thisyear;
$month = isset($_GET['month']) ? $_GET['month'] : $thismonth;
$day = isset($_GET['day']) ? $_GET['day'] : $today;

$prev_month = $month - 1;
$next_month = $month + 1;
$prev_year = $next_year = $year;
if ($month == 1) {
  $prev_month = 12;
  $prev_year = $year - 1;
} else if ($month == 12) {
  $next_month = 1;
  $next_year = $year + 1;
}
$preyear = $year - 1;
$nextyear = $year + 1;

$predate = date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year));
$nextdate = date("Y-m-d", mktime(0, 0, 0, $month + 1, 1, $year));

// 1. 총일수 구하기
$max_day = date('t', mktime(0, 0, 0, $month, 1, $year)); // 해당월의 마지막 날짜
//echo '총요일수'.$max_day.'<br />';

// 2. 시작요일 구하기
$start_week = date("w", mktime(0, 0, 0, $month, 1, $year)); // 일요일 0, 토요일 6

// 3. 총 몇 주인지 구하기
$total_week = ceil(($max_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', mktime(0, 0, 0, $month, $max_day, $year));
?>

<body>
  <!-- 헤더 가져오기(네비) -->
  <?php include $_SERVER['DOCUMENT_ROOT']."/rachel/template/header.php" ?>
  <!-- 게시판 타이틀 -->
  <h2 id="boardTitle">
    <span class="material-symbols-outlined">draw</span>
    일기장
    <span class="material-symbols-outlined">menu_book</span>
  </h2>
  <div class="">
    <table class="">
      <tr>
        <td>
          <a href=<?php echo '/rachel/diary/diary.php?year='.$preyear.'&month='.$month . '&day=1'; ?>>◀◀</a>
        </td>
        <td>
          <a href=<?php echo '/rachel/diary/diary.php?year='.$prev_year.'&month='.$prev_month . '&day=1'; ?>>◀</a>
        </td>
        <td class="height-80" colspan="3">
          <a href=<?php echo '/rachel/diary/diary.php?year=' . $thisyear . '&month=' . $thismonth . '&day=1'; ?>>
            <?php echo "&nbsp;&nbsp;" . $year . '년 ' . $month . '월 ' . "&nbsp;&nbsp;"; ?></a>
          </td>
          <td>
            <a href=<?php echo '/rachel/diary/diary.php?year='.$next_year.'&month='.$next_month.'&day=1'; ?>>▶</a>
          </td>
          <td>
            <a href=<?php echo '/rachel/diary/diary.php?year='.$nextyear.'&month='.$month.'&day=1'; ?>>▶▶</a>
          </td>
        </tr>
        <tr class="width-100">
          <th class="width-14">일</td>
          <th class="width-14">월</th>
          <th class="width-14">화</th>
          <th class="width-14">수</th>
          <th class="width-14">목</th>
          <th class="width-14">금</th>
          <th class="width-14">토</th>
        </tr>
        
      <?php
      // 5. 화면에 표시할 화면의 초기값을 1로 설정
      $day=1;
      
      // 6. 총 주 수에 맞춰서 세로줄 만들기
      for($i=1; $i <= $total_week; $i++){
      ?>
      <tr>
        <?php


        // 7. 총 가로칸 만들기
        for ($j = 0; $j < 7; $j++) {
          // 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않음
          echo '<td class="height-80" valign="top">';
          if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))) {
            
            if ($j == 0) {
              // 9. $j가 0이면 일요일이므로 빨간색
              $style = "holy";
            } else if ($j == 6) {
              // 10. $j가 0이면 토요일이므로 파란색
              $style = "blue";
            } else {
              // 11. 그외는 평일이므로 검정색
              $style = "black";
            }
            
            // 0을 포함한 월,일 표현
            $monthTwo = sprintf('%02d',$month);
            $dayTwo = sprintf('%02d',$day);

            // 각각 날짜
            $thisdate = $year.'-'.$monthTwo.'-'.$dayTwo;
            
            // 각 날짜에 일기가 있는지 확인(row수로 확인)
            $diarysql= query("SELECT * FROM diary WHERE id = '".$userid."' AND date= '".$thisdate."'"); 
            $diaryrow = mysqli_num_rows($diarysql);
            $diary = $diarysql->fetch_array();
            
            // 12. 오늘 날짜면 굵은 글씨
            if ($year == $thisyear && $month == $thismonth && $day == date("j")) {
            // 13. 날짜 출력
              // 오늘날짜
              if( $diaryrow == 0 ){ //일기가 없으면
                echo '<a href="/rachel/diary/diary_write.php?date='.$year.'-'.$monthTwo.'-'.$dayTwo.'" class="today a-width-height"><font class='.$style.'>';
                echo $day;
                echo '</font></a>';
              }else{  //있으면
                echo '<a href="/rachel/diary/diary_read.php?diaryIdx='.$diary['diaryIdx'].'" class="today a-width-height"><font class='.$style.'>';
                echo $day.'<p><span class="material-symbols-outlined">deceased</span></p>';
                echo '</font></a>';
              }   
            } else {
              // 그외날짜
              if( $diaryrow == 0 ){ //일기가 없으면
                echo '<a href="/rachel/diary/diary_write.php?date='.$year.'-'.$monthTwo.'-'.$dayTwo.'" class="a-width-height"><font class='.$style.'>';
                echo $day;
                echo '</font></a>';
              }else{  //있으면
                echo '<a href="/rachel/diary/diary_read.php?diaryIdx='.$diary['diaryIdx'].'" class="a-width-height"><font class='.$style.'>';
                echo $day.'<p><span class="material-symbols-outlined">deceased</span></p>';
                echo '</font></a>';
              }  
            }
            
            // 14. 날짜 증가
            $day++;
          }
            echo '</td>';
        }

        
        ?>
      </tr>
      <?php } ?>

      
    </table>
  </div>

</body>
</html>
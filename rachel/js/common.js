// 비로그인 상태 
function plzLogin(){
  alert('로그인이 필요한 서비스입니다.');
  location.href = "/rachel/login/login.php";
}

// 로그인 form check
function doSubmit(){
  let loginform = document.loginForm;
  //아이디
  if( !loginform.id.value ){
    alert('아이디를 입력해주세요');
    loginform.id.focus();
    return false;
  }

  //비밀번호
  if( !loginform.pw.value ){
    alert('비밀번호를 입력해주세요');
    loginform.pw.focus();
    return false;
  }  
  
  loginform.submit();

}


// 회원가입 form check
function checkJoin(){
  let joinform = document.joinForm;
  let pw = document.getElementById("joinPw1").value;
  let pwcheck = document.getElementById("joinPw2").value;

  let idRegExp = /^[a-zA-z0-9]{4,12}$/;
  let password1RegExp = /^[a-zA-z0-9]{4,12}$/;
  let nameRegExp = /^[가-힣]{2,4}$/;
  // 아이디
  if( !joinform.id.value || !idRegExp.test(joinform.id.value) ){
    alert('아이디는 영문 대소문자와 숫자를 이용하여 4~12자리로 입력해주세요');
    joinform.id.value = "";
    joinform.id.focus();
    return false;
  }else if( !pw || !password1RegExp.test(pw)){
    // 비밀번호
    alert('비밀번호를 영문 대소문자와 숫자를 이용하여 4~12자리로 입력해주세요');
    joinform.pw.value = "";
    joinform.pw.focus();
    return false;
  }else if( !pwcheck ){
    // 비밀번호 확인
    alert('비밀번호 확인을 입력해주세요');
    document.getElementById("joinPw2").focus();
    return false;
  }
  else if( pw != pwcheck ){
    // 비밀번호 확인
    alert('비밀번호가 일치하지 않습니다.');
    document.getElementById("joinPw2").value = "";
    document.getElementById("joinPw2").focus();
    return false;
  }else if( !joinform.userName.value || !nameRegExp.test(joinform.userName.value) ){
    alert('이름을 입력하세요.(한글로 2~4자리)');
    joinform.userName.focus();
    return false;
  }else{
    joinform.submit();
  }
  

}

//내정보 비번수정 화면
function changePw(){
  // form 태그 액션주소 바꾸기-탈퇴와 같은 form에 위치하기 때문에
  document.pwChangeForm.action = "/rachel/mypage/change_pw_ok.php";
  // form check함수 - 비번수정과 탈퇴 나누기 위한 클래스 삭제(on이 있으면 탈퇴)
  let nowpw = document.getElementById("nowPw")
  nowpw.classList.remove('on');

  let prepw = document.getElementById('prePw');
  let newpw = document.getElementById('newPw');
  let checkpw = document.getElementById('checkNewPw');
  let changePwBtn = document.getElementById('changePwBtn');
  let leavepw = document.getElementById('leavePw');


  if(changePwBtn.classList.contains('none','on')){
    prepw.classList.remove('hidden');
    newpw.classList.remove('hidden');
    checkpw.classList.remove('hidden');
    changePwBtn.classList.remove('none');
    leavepw.classList.add('hidden');
  }else if(changePwBtn.classList.contains('on')){
    prepw.classList.add('hidden');
    newpw.classList.add('hidden');
    checkpw.classList.add('hidden');
    changePwBtn.classList.add('none');
  }


}

// 내정보 탈퇴 화면
function leave(){
  // form 태그 액션주소 바꾸기-비밀번호 변경과 같은 form에 위치하기 때문에
  document.pwChangeForm.action = "/rachel/mypage/leave.php";
  // form check함수 - 비번수정과 탈퇴 나누기 위한 클래스 추가(on이 있으면 탈퇴)
  let nowpw = document.getElementById("nowPw")
  nowpw.classList.add('on');

  let prepw = document.getElementById('prePw');
  let newpw = document.getElementById('newPw');
  let checkpw = document.getElementById('checkNewPw');
  let changePwBtn = document.getElementById('changePwBtn');
  let leavepw = document.getElementById('leavePw');
 
  if(nowpw.classList.contains('on')){
      prepw.classList.add('hidden');
      newpw.classList.add('hidden');
      checkpw.classList.add('hidden');
      changePwBtn.classList.add('none');
      leavepw.classList.remove('hidden');
      
    }
  
}

//내정보 form check(비번수정, 탈퇴)
function checkPw(){
  let pwform = document.pwChangeForm;
  let prepw = document.getElementById("prePwCh").value;
  let newpw = document.getElementById("newPwCh").value;
  let checkpw = document.getElementById("checkPwCh").value;
  let nowpw = document.getElementById("nowPw");

  let password1RegExp = /^[a-zA-z0-9]{4,12}$/;

  if( nowpw.classList.contains('on') ){ // 탈퇴일 경우
    if( !nowpw.value ){
      alert('비밀번호를 입력해주세요');
      nowpw.focus();
      return false;
    }
    let answer = confirm("정말 탈퇴하시겠습니까?");

    if(answer == true){
      document.pwChangeForm.submit();
    }else{
      return false;
    }

  }else{  // 비번 바꾸기일 경우
    if( !prepw ){
      // 기존비밀번호
      alert('현재 비밀번호를 입력하세요');
      document.getElementById("prePwCh").focus();
      return false;
    }else if( !newpw || !password1RegExp.test(newpw)){
      // 새 비밀번호
      alert('새 비밀번호를 영문 대소문자와 숫자를 이용하여 4~12자리로 입력해주세요');
      pwform.newpw = "";
      document.getElementById("newPwCh").focus();
      return false;
    }else if( !checkpw ){
      // 새 비밀번호 확인
      alert('새로운 비밀번호 확인을 입력해주세요');
      document.getElementById("checkPwCh").value = "";
      document.getElementById("checkPwCh").focus();
      return false;
    }
    else if( newpw != checkpw ){
      // 비밀번호 확인
      alert('새 비밀번호와 일치하지 않습니다.');
      document.getElementById("checkPwCh").value = "";
      document.getElementById("checkPwCh").focus();
      return false;
    }
  }
}


//게시판
// url 페이지 번호 가져오기
const urlParams = new URL(location.href).searchParams;
const page = urlParams.get('page');

// reply 등록 글자수 체크
function replyInsert(){
  let replyValue = document.getElementById('replyContent').value;
  let replyform = document.replyForm;

  if( replyValue.length == 0 ){
    alert('내용을 입력해주세요.');
    replyform.content.focus();
  }else if(replyValue.length == 200){
    alert('내용은 200자를 넘을 수 없습니다.');
  }else{
    replyform.submit();
  }
}

// reply 삭제
function deleteReply(replynum){
    // form 태그 액션주소 바꾸기-댓글쓰기와 같은 form에 위치하기 때문에
    document.replyForm.action = "/rachel/reply.php?ridx=" + replynum + "&page=" + page + "&mode=D";
    console.log(page);
    document.replyForm.submit();

}

// reply 수정
function updateReply(replynum){
  let replyValue = document.getElementById('reply'+replynum).value;
  let replyform = document.replyForm;
  let replyid = document.getElementById('reply'+replynum);

  if( replyValue.length == 0 ){
    alert('내용을 입력해주세요.');
    replyid.focus();
  }else if( replyValue.length == 200 ){
    alert('내용은 200자를 넘을 수 없습니다.');
    replyid.focus();
  }else{
    document.replyForm.action = "/rachel/reply.php?ridx=" + replynum + "&page=" + page + "&mode=U";
    replyform.submit();
  }

  
}

// reply 수정하기 누르면 readonly 없애기
function updateReadonlyReply(replynum, replyCon){
  let replyId = document.getElementById("reply" + replynum);
  replyId.readOnly = false;
  
  replyId.focus();

  // 커서 맨뒤로 보내기
  replyId.value = '';
  replyId.value = replyCon;

}

// read.php에서 목록누르면 다르게 보내주기
function boardList(){
  // 검색해서 글을 클릭 후 목록을 눌렀을때
  if( page == null ){
    history.back();
  }else{
  // 목록에서 글을 클릭 후 목록을 눌렀을때
    location.href = "/rachel/index.php?page=" + page;
  }
}


// 게시판 빈값체크
function checkBoard(){
  let boardform = document.boardForm;
  let titleval = boardform.title.value;
  let contentval = boardform.content.value;

  // 제목확인
  if(titleval == 0){  
    alert("제목을 입력해주세요");
    boardform.title.focus();
    return false;
  }else if(titleval > 80){
    alert("제목은 80자를 넘을 수 없습니다.")
    boardform.title.focus();
  }else if( contentval == 0 ){
    boardform.content.focus();
    return false;
  }

  boardform.submit();
}

// 일기장
// 일기장 빈값 formcheck
function checkDiary(){
  let diaryform = document.diaryUploadForm;
  let contentval = diaryform.content.value;
  
  // 내용 확인
  if( contentval == 0 ){
    alert("내용을 입력하세요.")
    diaryform.content.focus();
    return false;
  }

  diaryform.submit();
}



// 일기장 수정 formcheck (파일없음)
function checkDiaryfile(){
  let diaryform = document.diaryUploadForm;
  let contentval = diaryform.content.value;
  let fileinput = diaryform.upfile.value;
  let new_file = document.getElementById('newfile');
  
  // 내용 확인
  if( contentval == 0 ){
    alert("내용을 입력하세요.")
    diaryform.content.focus();
    return false;
  }
  
  // 파일추가 확인하기
  if( fileinput ){
    new_file.value = "on";
  }

  diaryform.submit();
  
}

// 일기장 파일있으면 휴지통 버튼 제어
function delBinBnt(){
  let prefile = document.getElementById('preFile');
  let fileShow = document.getElementById('upfile');
  let change_file = document.getElementById('change_file');

  prefile.remove();
  change_file.value = "del";  
  fileShow.type = "file";

}

// 일기장 수정 formcheck (파일 이미 존재)
function checkDiaryfileUp(){
  let diaryform = document.diaryUploadForm;
  let contentval = diaryform.content.value;
  let fileinput = diaryform.upfile.value;
  let change_file = document.getElementById('change_file');

  
  // 내용 확인
  if( contentval == 0 ){
    alert("내용을 입력하세요.")
    diaryform.content.focus();
    return false;
  }
  
  // 파일추가 확인하기
  if( fileinput ){
    change_file.value = "on";
    
  }

  diaryform.submit();
  


}
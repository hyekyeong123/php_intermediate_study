<?php
// <!-- $pdo 변수를 생성하고 데이터 베이스로 접속하는 인클루드 파일 -->
include_once __DIR__.'/../includes/dbcon.php';

// totalljokes()함수가  포함된 인클루드 파일
include_once __DIR__.'/../includes/functions.php';

// 함수 호출하기
echo totalJokes($pdo);



?>

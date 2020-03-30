<!-- 유머 글 목록 보여주는 곳 -->
<?php

try{
    // 데이터 베이스 연결
    include __DIR__.'/../includes/dbcon.php';
    include __DIR__.'/../includes/functions.php';

    // // --------------------------------------------------------------------------------------------------
    // // $sql = "SELECT `joke`.`id`,`joketext`,`name`,`email` FROM `joke` INNER JOIN `author` ON `authorid`=`author`.`id`";
    // // //아이디를 가져와 나중에 삭제하기 용이 
    // // $jokes = $pdo->query($sql);
    
    // // 간단하게 함수로 표현
    // $jokes = allJokes($pdo);
    // // -------------------------------------------------------------------------------------------------------
    
    // // while($row = $result->fetch()){
        // //     $jokes[] = [
            // //         'id'=>$row['id'],
            // //         'joketext'=>$row['joketext']
            // //     ];
            // // } //jokes.html.php에서 한번 돌림
    //-------------------------------------------------------------------------- 
    $result = findAll($pdo,'joke');
    //joke테이블에서 모두 가져오기

    $jokes = [];
    foreach($result as $joke){

        //글 작성자 검색하기
        $author = findById($pdo,'author'.'id',$joke['authorId']);

        $jokes[] = [
            `id` => $joke['id'],
            `joketext` => $joke['joketext'],
            `jokedate` => $joke['jokedate'],
            `name` => $author['name'],
            `email` => $author['email'],
        ];
    }
    // --------------------------------------------------------------------------
    $title = '유머 글 목록';
    $totalJokes = total($pdo,'joke');
    // // 유머 글의 목록 개수 변수 생성

    // 즉시 브라우저로 보내지 않고 $output 변수에 저장했다가 나중에 보내기
    // 출력 버퍼링 시작
    ob_start();
    include __DIR__. '/../templates/jokes.html.php'; //유머목록 가져오는 코드
    $output = ob_get_clean();

    
}catch(PDOException $e){
    $title = '오류가 발생하였습니다.';
    $output = '데이터 베이스 오류:'.$e->getMessage().',위치 : '.$e->getFile().':'.$e->getLine();
}

include __DIR__ .'/../templates/layout.html.php'; //$out값 보내기
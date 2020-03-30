<!--  유머 글 등록 컨트롤러 -->

<!-- 1. POST로 joketext 변수가 넘어오지 않으면 품을 출력한다. -->
<?php
    if(isset($_POST['joketext'])){
        // joketext를 post값으로 받아 왔다면(폼이 제출되었음)
        try{
            // 데이터베이스 연결하기
            include __DIR__.'/../includes/dbcon.php';
            include __DIR__.'/../includes/functions.php';

            insert($pdo,'joke',[
                'authorId'=>1,
                'jokeText'=>$_POST['joketext'],
                'jokedate'=>new DateTime()]);
                                            //form으로부터 입력 받은 값        //DateTime() 생성

            header('location:jokes.php'); //목록
        }catch(PDOException $e){
            $title = '오류가 발생하였습니다.';
            $output = '데이터 베이스 오류: '.$e->getMessage().'위치 : '.$e->getFile().','.$e->getLine();
        }
    }else{
        // post값으로 받아오지 못했다면 addjoke.html.php 파일을 $output 이라는 변수에 담아 브라우저로 전송
        // submit이 아니라 맨 처음 값

        
        $title = '유머 글 등록하기';
        ob_start();
        include __DIR__ .'/../templates/addjoke.html.php';
        $output = ob_get_clean();
    }
    include __DIR__.'/../templates/layout.html.php';
?>

<!-- 2. joketext 변수가 넘어오면 데이터베이스에 신규 유머 글을 출력한다.  -->

<!-- 1. POST로 joketext 변수가 넘어오지 않으면 품을 출력한다. -->
<?php
    if(isset($_POST['joketext'])){
        // joketext를 post값으로 받아 왔다면(폼이 제출되었음)
        try{
            // 데이터베이스 연결하기
            include __DIR__.'/../includes/dbcon.php';

            //sql 입력하기(준비된 구문 사용하기)
            $sql = "INSERT INTO `joke` SET `joketext`=:joketext,`jokedate`=CURDATE()";
            //CURDATE()는 현재 날짜를 구하는 mysql의 함수이다.
            
            
            // ---------------------------------------------------------------------
            $stmt = $pdo->prepare($sql);
            // pdo 객체가 prepare메소드를 사용하겠다.

            $stmt->bindValue(':joketext',$_POST['joketext']);

            $stmt->execute();

            header('location:jokes.php');
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

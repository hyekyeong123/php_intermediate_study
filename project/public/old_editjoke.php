<!--  유머 글 수정 컨트롤러 -->


<!-- 1. POST로 joketext 변수가 넘어오지 않으면 품을 출력한다. -->
<?php
    include __DIR__.'/../includes/dbcon.php';
    include __DIR__.'/../includes/functions.php';
    // 폼 전송여부와 관계없이 두 파일에 정의된 데이터베이스 함수 사용가능

    try{
        // try문의 if문을 감싸는 이유는 if문이나 else문에서 에러가 발생할 위험이 있기 때문

        if(isset($_POST['joketext'])){
        // joketext를 post값으로 받아 왔다면(폼이 제출되었음)
            // 데이터베이스 연결하기

            // 버전 1
            // updateJoke($pdo,$_POST['jokeid'],$_POST['joketext'],1);

            // 버전 3
            update($pdo,'joke','id', [
                'id' => $_POST['jokeid'],
                'joketext'=>$_POST['joketext'],
                'authorId'=>1
            ]);
            //   function update($pdo, $table, $primaryKey, $fields)
            // function updateJoke($pdo, $jokeId, $joketext, $authorId){
            header('location:jokes.php');
        }else{
            // 폼 출력 코드를 불러온 다음 유머글 정보 가져오기

            // post값으로 받아오지 못했다면 editjoke.html.php 파일을 $output 이라는 변수에 담아 브라우저로 전송

            $joke = findById($pdo,'joke','id', $_GET['id']); //id가 동일한 joke 테이블의 모든 것 가져오기
            // 수정할 곳의 아이디는 반드시 get으로 가져와야함


            $title = '유머 글 수정하기';


            ob_start();
            include __DIR__ .'/../templates/editjoke.html.php';
            $output = ob_get_clean();
        }
    }catch(PDOException $e){
        $title = '오류가 발생하였습니다.';
        $output = '데이터 베이스 오류: '.$e->getMessage().'위치 : '.$e->getFile().','.$e->getLine();
    }
    include __DIR__.'/../templates/layout.html.php';
?>

<!-- 2. joketext 변수가 넘어오면 데이터베이스에 신규 유머 글을 출력한다.  -->

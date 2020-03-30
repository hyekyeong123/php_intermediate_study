<!--  유머 글 수정 컨트롤러 -->
<?php
    include __DIR__.'/../includes/dbcon.php';
    include __DIR__.'/../includes/functions.php';
   
    try{
        // try문의 if문을 감싸는 이유는 if문이나 else문에서 에러가 발생할 위험이 있기 때문

        if(isset($_POST['joke'])){
            $joke = $_POST['joke'];
            $joke['jokedate'] = new DateTime();
            $joke['authorId'] = 1;
            
            save($pdo, 'joke','id',$joke);


            // save($pdo,'joke','id', [
            //     'id' => $_POST['jokeid'],
            //     'joketext'=>$_POST['joketext'],
            //     'jokedate' => new DateTime(),
            //     'authorId'=>1
            // ]);
            
            header('location:jokes.php');
        }else{
            if(isset($_GET['id'])){
                //id가 있을 때에만(수정할 때만) 데이터베이스에서 글 데이터를 가져오도록
                $joke = findById($pdo,'joke','id',$_GET['id']); //id가 동일한 joke 테이블의 모든 것 가져오기
                // 수정할 곳의 아이디는 반드시 get으로 가져와야함
            }
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

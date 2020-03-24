<?php
    try {
    // 데이터베이스 연결하기
    include __DIR__.'/../includes/dbcon.php';

        //sql 입력하기(준비된 구문 사용하기)
        $sql = "DELETE from joke where id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_POST['id']);
        // hidden으로 보냈으니까

        $stmt->execute();

        header('location:jokes.php');
    } catch (PDOException $e) {
        $title = '오류가 발생하였습니다.';

        $output = '데이터 베이스 오류: ' . $e->getMessage() . '위치 : ' . $e->getFile() . ',' . $e->getLine();
    }
include __DIR__ . '/../templates/layout.html.php';
?>

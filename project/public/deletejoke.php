<?php
    try {
    // 데이터베이스 연결하기
        include __DIR__.'/../includes/dbcon.php';
        include __DIR__.'/../includes/functions.php';

        delete($pdo,'joke','id',$_POST['id']);
        // function delete($pdo, $table, $primaryKey, $id){

        header('location:jokes.php');
    } catch (PDOException $e) {
        $title = '오류가 발생하였습니다.';

        $output = '데이터 베이스 오류: ' . $e->getMessage() . '위치 : ' . $e->getFile() . ',' . $e->getLine();
    }
include __DIR__ . '/../templates/layout.html.php';
?>

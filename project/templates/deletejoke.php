<?php
    try{
        include __DIR__."/../includes/dbcon.php";
        include __DIR__."/../includes/functions.php";

        daleteJoke($pdo,$_POST['id']);
        header('location:jokes.php');
    }catch(PDOException $e){
        $title = '오류가 발생하였습니다.';

        $output = '데이터 베이스 서버에 연결 할 수 없습니다.'.$e->getMessage().'위치 : '.$e->getFile()." , ".$e->getLine();
    }   
    include __DIR__."/../templates/layout.html.php";
?>
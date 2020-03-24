<?php
    function totalJokes($pdo){
        //  유머 글 개수 출력하는 함수
        $query = $pdo->prepare('SELECT count(*) from joke');

        $query->execute();

        $row = $query->fetch();

        return $row[0];

    }


    include_once __DIR__.'/../includes/dbcon.php';
    echo totalJokes($pdo);

    // 위에 것을 두개로 분리한 것-----------------------------------------------
    function query($pdo, $sql){
        $query = $pdo->prepare($sql);
        $query->execute();
    }


    function totalJoke($pdo){
        $query = query($pdo, 'SELECT count(*) from `joke`');
        $row = $query->fetch();
        return $row[0];
    }
    
    
    function getJoke($pdo, $id){
        $query = query($pdo,'SELECT * from `joke` WHERE `id` = :id');
        return $query->fetch();

    }
?>
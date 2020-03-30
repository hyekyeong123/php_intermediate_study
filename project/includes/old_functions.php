<?php
    include_once __DIR__.'/../includes/dbcon.php';
    // joke 테이블의 글 수를 가져와 반환하는 함수

    // function totalJokes($pdo){
    //     //  유머 글 개수 출력하는 함수
    //     $query = $pdo->prepare('SELECT count(*) from joke');
    //     $query->execute();
    //     $row = $query->fetch();
    //     return $row[0];
    // }

    // function getJoke()


    echo totalJokes($pdo);

    // 위에 것을 두개로 분리한 것-----------------------------------------------

    // 쿼리를 입력받아 실행하는 함수------------------------------------------------------------------------------
    function query($pdo, $sql, $parameters=[]){
        $query = $pdo->prepare($sql);
        // foreach($parameters as $name => $value){
        //     // ex) $name = :id, $value = $id
        //     $query->bindValue($name, $value);

        // }
        $query->execute($parameters);
            // 매개변수정보를 인자로 직접 받으면 bindValue()생락 가능함(매개변수 일일이 바인드 할 필요 없음)
        return $query;
    }
    // ------------------------------------------------------------------------------------------------------------
    function totalJokes($pdo){
        // //$query() 함수로 보낼 빈 배열 생성(받아야 할 인수가 세개 인데 두개만 보내면 에러가 나기 때문)
        // $parameters = [];
        // 이렇게 하지 않고도 query()함수에서 기본값을 지정하면 됨
        $query = query($pdo, 'SELECT count(*) from `joke`');
        $row = $query->fetch();
        return $row[0];
    }
    // --------------------------------------------------------------------- 
    function getJoke($pdo, $id){
        //  query() 함수에서 사용할 $parameters 배열 생성
        $parameters = [':id'=>$id];
        // queru() 함수를 호출할 때 $parameters 배열 제공
        $query = query($pdo,'SELECT * from `joke` WHERE `id` = :id',$parameters);

        return $query->fetch();
    }
// ----------------------------------------------------------
    // 날짜 자동으로 형식변환 도와주는 함수
    function processDates($fields){
        foreach ($fields as $key => $value) {
            //배열의 키와 값을 분리할 때 사용 
            if ($value instanceof DateTime {
                $fields[$key] = $value->format('Y-m-d H:i:s');
            }
        }
        return $fields;
    }
    // ---------------------------------------------------------------------------
    // // 새 유머 글을 추가하는 함수
    // function insertJoke($pdo, $joketext, $authorId){
    //     $query = 'INSERT INTO `joke` (`joketext`,`jokedate`,`authorId`) VALUES (:joketext, CURDATE(), :authorId)';

    //     $parameters = [
    //         ':joketext'=>$joketext,
    //         ':authorId'=>$authorId
    //     ];
    //     query($pdo, $query, $parameters);
    // }

    function insertJoke($pdo,$fields)
    {
        $query='INSERT INTO `joke` (';

        foreach($fields as $key => $value){
            $query .= '`' . $key . '`=:' . $key . ',';
        }
        $query = rtrim($query,',');

        $query .= ') VALUES (';

        foreach($fields as $key => $value){
            $query .= '`' . $key . '`=:' . $key . ',';
        }
        $query = rtrim($query, ',');
        $query .= ')';

        // 자동으로 날짜 값 집어넣기------------------------
        $fields = processDates($fields);
        // -------------------------------------
        query($pdo,$query,$fields);
        
    }
    // -------------------------------------------------------------------------------------------
    // 유머 글 수정하는 함수
    // 버전 1
    // function updateJoke($pdo, $jokeId, $joketext, $authorId){
        // $parameters= [
        //     ':id'=>$jokeId,
        //     ':joketext'=>$joketext,
        //     ':authorId'=>$authorId
        // ];
        // query($pdo,"UPDATE `joke` SET `authorId`=:authorId,`joketext`=:joketext WHERE `id`=:id",$parameters);
    // }


    // 버전 2 업그레이드
    function updateJoke($pdo, $fields){
        $query = "UPDATE `joke` SET";
        foreach ($fields as $key => $value) {
            $query .='`'.$key.'`=:'.$key.',';
        }
        $query = rtrim($query,','); //마지막 , 제거하기
        $query .="WHERE `id` =:primaryKey";

        $fields = processDates($fields);

        // primaryKey 변수 설정하기
        $fields['primaryKey'] = $fields['id'];

        query($pdo,$query,$fields);
    }
// ---------------------------------------------------------------------------------
    //  유머 글 삭제하는 함수
    function daleteJoke($pdo,$id){
        $parameters=[
            ':id'=$id
        ];
        query($pdo,"DELETE FROM `joke` WHERE `id`=:id,$parameters");
    }
    // -----------------------------------------------------------------
    // 유머 글과 작성자 정보 한번에 불려오는 함수
    function allJokes($pdo){
        $jokes = query($pdo,"SELECT `joke`.`id`, `joketext`,`jokedate`, `name`, `email` FROM `joke` INNER JOIN `author` ON `authorid` = `author`.`id`");
        // from -> main이 되는 테이블, INNER JOIN-> 연결할 테이블 ON-> 동일한 값(순서대로)
        
        return $jokes->fetchAll();
        // PDOStatement::fetchAll — Returns an array containing all of the result set rows(row의 모든 결과값을 리턴)
    }


    // ---------------------------------------------------------------------------------------------------------------
    // 작성자 목록 함수
    function allAuthors($pdo){
        $authors = query($pdo,'SELECT * FROM `author`');
        return $authors->fetchALl();
    }

    function deleteAuthor($pdo, $id){
        $parameters = [':id' => $id];

        query($pdo,'DELETE FROM `author` WHERE `id` = :id', $parameters);
    }

    // ---------------------------------------------------------------------------------
    function insertAuthor($pdo,$fields){
        $query = 'INSERT INTO `author` (';

        foreach($fields as $key => $value){
            $query .= '`'.$key.'`,';
            // 2개 이상 일 수도 있으니 ,를 붙여줘야함, 일단은
        }
        $query = rtrim($query,',');
        // 가장 마지막 부분 , 지우기

        $query .= ') VALUES ('  ;

        foreach ($fields as $key => $value) {
            $query .= ':' . $key . '`,';
            // 2개 이상 일 수도 있으니 ,를 붙여줘야함, 일단은
        }

        $query = rtrim($query, ',');
        $query = ')';

        $fields = processDates($fields);

        query($pdo, $query, $fields);

    }
    // ----------------------------------------------------------------------------------------
    
    // 모든 목록 가져오기 함수
    function findAll($pdo, $table){
        $result = query($pdo, "SELECT * FROM `". $table ."`");

        return $result->fetchAll();
    }

    function delete($pdo, $table,$primaryKey, $id){
        $parameters = [':id' => $id];
        query($pdo, "DELETE FROM `".$table."` WHERE `.$primaryKey.` = :id", $parameters);
    }


    function insert($pdo, $table, $fields)
    {
        $query = "INSERT INTO `".$table."` (";
        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '`,';
        }
        $query = rtrim($query, ',');
        $query .= ') VALUES (';
        foreach ($fields as $key => $value) {
            $query .= ':' . $key . '`,';
        }
        $query = rtrim($query, ',');
        $query = ')';
        $fields = processDates($fields);
        query($pdo, $query, $fields);
    }


    function update($pdo, $table, $primaryKey, $fields)
    {
        $query = "UPDATE `".$table."` SET";
        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '`=:' . $key . ',';
        }
        $query = rtrim($query, ','); //마지막 , 제거하기
        $query .= "WHERE `".$primaryKey."` =:primaryKey";

        
        // :primaryKey 변수 설정하기
        $fields['primaryKey'] = $fields['id'];
        //WHERE 절의 :primaryKey 자리는 수정할 글 id가 들어갈 자리
        // 배열의 각 키는 중복되지 않는 고유한 값
        // id는 이미 set 절에서 사용되므로  primary 키를 별도로 $fields 배열에 만들고 여기에 id값 저장
        
        $fields = processDates($fields);
        query($pdo, $query, $fields);
    }


    function findById(){

    }
?>
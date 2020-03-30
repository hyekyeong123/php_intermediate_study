<?php
    include_once __DIR__.'/../includes/dbcon.php';

    class DatabaseTable{
        public $pdo;
        public $table;
        public $primaryKey;

        $databaseTable = new DatabaseTable();
        $databaseTable->pdo->$pdo;
        $databaseTable->table->'joke';
        $databaseTable->primarykey->'id';

        private function query($pdo, $sql, $parameters=[]){
            $query = $this->pdo->prepare($sql);
            $query->execute($parameters);
            return $query;
        }

    // ----------------------------------------------------------
    // 날짜 자동으로 형식변환 도와주는 함수
    private function processDates($fields){
            foreach ($fields as $key => $value) {
                if ($value instanceof DateTime {
                    $fields[$key] = $value->format('Y-m-d H:i:s');
                }
            }
            return $fields;
        }
        // ---------------------------------------------------------------------------------------------------------------
        public function findAll($pdo, $table){
            $result = $this->query($pdo, "SELECT * FROM `". $this->table ."`");
            
            return $result->fetchAll();
        }
          

        public function delete($pdo, $table, $primaryKey, $id){
            $parameters = [':id' => $id];
            $this->query($pdo, "DELETE FROM `".$table."` WHERE `.$primaryKey.` = :id", $parameters);
        }


    private function insert($pdo, $table, $fields)
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
            $this->query($pdo, $query, $fields);
        }


    private function update($pdo, $table, $primaryKey, $fields){
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
            $this->query($pdo, $query, $fields);
        }
        public function findById($pdo, $table, $primaryKey, $value){
            $query = "SELECT * FROM `".$table."` WHERE `".$primaryKey."` =:value";
            
            $parameters = [
                'value' = > $value
            ];
            
            $query =  $this->query($pdo, $query, $parameters);
            
            return $query->fetch();
        }
    
    
    // 전체 글 개수 확인
        public function total($pdo, $table){
            $query = $this->query($pdo,"SELECT COUNT(*) FROM `".$table."`");
            $row = $query->fetch();
            return $row[0];
        }
    
    // --------------------------------------------------------------------------------------
    public function save($pdo, $table, $primaryKey, $record){
        try{
            // 등록하기
            if($record[$primaryKey] == ''){
                // 만약에 primaryKey가 공백이라면 null값 입력(id칼럼에 빈 문자열이 들어가지 않도록)
                // 빈 문자열이 그대로 쿼리에 전달되면 오류가 발생함
                // 빈 문자열 대신 null값을 지정하면 mysql이 자동으로 auto-increment 기능을 발생시켜 신규 ID
                $record[$primaryKey] = null;
            }
                $this->insert($pdo, $table, $record);
        }catch(PDOException $e){
                // 등록이 실패할 시 수정하기
                $this->update($pdo, $table, $primaryKey, $record);
        }
    }
    }
    ?>
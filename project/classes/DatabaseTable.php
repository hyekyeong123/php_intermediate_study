<?php
    include_once __DIR__.'/../includes/dbcon.php';

    class DatabaseTable{

        // 클래스 변수를 private로 지정하면 안전하게 보호 가능
        private $pdo;
        private $table;
        private $primaryKey;

        public function __construct(PDO $pdo,string $table, string $primaryKey)
        {
            // 클래스를 새로 생성할 때마다 자동으로 만드는 것
            $this->pdo=$pdo;
            $this->table=$table;
            $this->primaryKey= $primaryKey;
        }

        private function query($sql, $parameters=[]){
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
   
        public function findAll(){
            $result = $this->query("SELECT * FROM `". $this->table ."`");
            return $result->fetchAll();
        }

        public function delete($id){
            $parameters = [':id' => $id];
            $this->query("DELETE FROM `".$this->table."` WHERE `.$this->primaryKey.` = :id", $parameters);
        }


        private function insert($fields)
        {
            $query = "INSERT INTO `".$this->table."` (";
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
            $fields = $this->processDates($fields);
            $this->query($query, $fields);
        }


        private function update($fields){
            $query = "UPDATE `".$this->table."` SET";
            foreach ($fields as $key => $value) {
                $query .= '`' . $key . '`=:' . $key . ',';
            }
            $query = rtrim($query, ','); //마지막 , 제거하기
            $query .= "WHERE `".$this->primaryKey."` =:primaryKey";
            
            $fields['primaryKey'] = $fields['id'];
            
            $fields = $this->processDates($fields);
            $this->query($query, $fields);
        }



        public function findById($value){
            $query = "SELECT * FROM `".$this->table."` WHERE `".$this->primaryKey."` =:value";
            
            $parameters = [
                'value' = > $value
            ];
            
            $query =  $this->query($query, $parameters);
            
            return $query->fetch();
        }
    
    
    // 전체 글 개수 확인
        public function total(){
            $query = $this->query("SELECT COUNT(*) FROM `".$this->table."`");
            $row = $query->fetch();
            return $row[0];
        }
    
    // --------------------------------------------------------------------------------------
        public function save($record){
            try{
            // 등록하기
                if($record[$this->primaryKey] == ''){
                    $record[$this->primaryKey] = null;
                }
                $this->insert($record);
            }catch(PDOException $e){
                // 등록이 실패할 시 수정하기
                $this->update($record);
            }
        }
    }
    ?>
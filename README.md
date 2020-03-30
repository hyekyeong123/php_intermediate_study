# pdo란??
> 이기종 데이터베이스에 접근하는 공통 API를 제공하는 것을 목적으로 만들어짐
> PDO 는 객체 스타일의  API 만을 제공
> mysql API  와는 달리 Prepared Statement 를 제공하므로 SQL Injection 방어에 사용될  수 있습니다.


> 데이터베이스에 연결하기 위해서는 PDO 객체의 생성자에 DSN(Data Source Name), 아이디, 비밀번호를 인자로 입력
> DSN의 port는 기본값 3306인 경우 생략 가능함

> 데이터 베이스 연결 객체를 생성한 후 **setAttribute** 메소드를 사용해서 두 가지 속성 지정
```php
    <?php
    $dsn = "mysql:host=localhost;port=3306;dbname=testdb;charset=utf8";
    try {
        $db = new PDO($dsn, "testuser", "testuser");
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        //Preppared Statement 를 데이터베이스가 지원 하지 않을 경우 에뮬레이션 하는 기능으로 false 를  지정해서 데이터베이스의 기능을 사용하도록 합니다.

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // PDO::ATTR_ERRMODE : 이 속성은 PDO 객체가 에러를 처리하는 방식을 결정합니다.
        // PDO::ERRMODE_EXCEPTION 은 에러가 발행했을때 PDOException 을 throw 하도록합니다. 이 경우 try {} catch{} 를 사용하여 에러를 처리하면 됩니다. 
        // 다른 방법으로는 PDO::ERRMODE_SILENT(에러 코드만 설정), PDO::ERRMOdE_WARNING(E_WARNING 발생)이 있습니다.

        $keyword = "%테스트%";
        $no = 1;

        $query = "SELECT num, name FROM tb_test WHERE name LIKE ? AND num > ?";
                                                                //쿼리에 값을 바꿔 넣을 곳에 ?(placeholder) 사용

        $stmt = $db->prepare($query); //스테이트먼트 사용
        $stmt->execute(array($keyword, $no)); //배열로 값을 입력
        $result = $stmt->fetchAll(PDO::FETCH_NUM); //결과 가져오기(숫자 인덱스 반환)

        // PDO::FETCH_ASSOC : 컬럼명이 키인 연관배열 반환
        // PDO::FETCH_BOTH : 위 두가지 모두
        // PDO::FETCH_OBJ : 컬럼명이 프로퍼티인 인명 객체 반환
 




        for($i = 0; $i < count($result); $i++) {
            printf ("%s : %s <br />", $result[$i][0], $result[$i][1]);
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
?>



```
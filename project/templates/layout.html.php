<!-- 전체 레이아웃의 기본  -->
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
</head>
<body>
    <header>
        <h1>인터넷 유머 세상</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index2.php">Home</a></li>
            <li><a href="jokes.php">유머 글 목록</a></li>
            <li><a href="addjoke.php">유머 글 목록 추가하기</a></li>
        </ul>
    </nav>
    <main>
        <?=$output?>
        <!-- main 코드 -->
    </main>
    <footer>
        $copy; IJDB 0217
    </footer>
</body>
</html>
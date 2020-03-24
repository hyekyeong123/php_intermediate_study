<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>성과 이름을 post방식으로 보내기</title>
</head>

<body>
    <form action="" method="post">
    <!-- 액션이 빈 값이면 현재 url로 폼을 전송함 -->
        <label for="firstname">이름 :</label>
        <input type="text" name='firstname' id='firstname'>
        
        <label for="lastname">성 :</label>
        <input type="text" name='lastname' id='lastname'>

        <input type="submit" value='제출'>
    </form>
</body>

</html>
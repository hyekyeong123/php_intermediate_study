<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO 형식으로 joketext만 불러오기</title>
</head>

<body>
    <!-- <?= $jokes[0] ?> -->
    <?php if (isset($error)) : ?>
        <!-- 에러가 있다면 -->
        <p>
            <?php echo $error; ?>
        </p>

    <?php else : ?>
        <!-- 에러가 없다면 -->
        <?php foreach ($jokes as $joke) : ?>
            <!-- 모두 반복 -->
            <blockquote>
                <!-- 인용문 -->
                <p>
                    <?php echo htmlspecialchars($joke, ENT_QUOTES, 'UTF-8') ?>
                </p>
            </blockquote>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>
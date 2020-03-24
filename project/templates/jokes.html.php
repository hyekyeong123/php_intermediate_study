<!-- 유머 글만 출력하는 코드 -->
<!-- 유머 글 목록을 볼 수 있음 -->
<p><?=$totaljokes?>개 유머 글이 있습니다. </p>
<?php foreach ($jokes as $joke) : ?>
    <blockquote>
        <p>
            <!-- 반복문 안에 각 유머글과 form이 있음 -->


            <!-- 내용 출력 -->
            <?= htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8') ?>

            (작성자 : <a href="mailto:<?= htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8') ?>
            </a>)


            <!-- 삭제하기 form -->
            <form action="deletejoke.php" method="POST">
                <input type="hidden" name='id' value="<?= $joke['id'] ?>">
                <input type="submit" value="삭제">
            </form>
        </p>
    </blockquote>
<?php endforeach; ?>
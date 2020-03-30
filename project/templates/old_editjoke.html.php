<!-- 유머 글 목록 수정하는 폼 -->
<form action="" method="POST">
    <!-- 속성의 값을 비워두면 폼은 현재 페이지로 다시 전송 -->

    <!-- 1. 먼저 수정할 아이디를 가져와야함 -->
    <input type="hidden" name='jokeid' value="<?php $joke['id'] ?>">


    <label for="joketext">유머 글을 입력해주세요</label>
    <textarea name="joketext" id="joketext" cols="3" rows="40">

        <!-- 2. 글 내용은 그대로 가져오기 -->
        <?php $joke['joketext'] ?>
    </textarea>
    <input type="submit" value="저장하기">
</form>
<?php
    updateJoke($pdo,$_POST['jokeid'],$_POST['joketext'],1);
?>
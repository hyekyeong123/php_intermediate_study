<!-- 유머 글 목록 수정, 입력하는 폼 -->
<form action="" method="POST">

    <!-- 1. 먼저 수정할 아이디를 가져와야함 -->
    <input type="hidden" name='jokeid' value="<?= $joke['id'] ?? '' ?>">
                                                        <!-- 널 병합 연산자 사용하기 -->
    <label for="joketext">유머 글을 입력해주세요</label>
    <textarea name="joketext" id="joketext" cols="3" rows="40">
        <?= $joke['joketext'] ?? ''?>
        <!-- 존재하지 않는다면 빈 값 -->
    </textarea>

    <input type="submit" value="저장하기">
</form>

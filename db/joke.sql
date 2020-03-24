CREATE TABLE `joke`(
    `id` int(10) not null AUTO_INCREMENT,
    `joketext` TEXT NULL,
    `jokedate` DATE NULL,
    PRIMARY KEY(`id`)    
);
insert into joke (joketext,jokedate) VALUES ('!false는 \'앗 거짓\'이라는 뜻이 아냐! 그냥 \'참\'이라고!','2020-03-22');

-- 관계형 데이터 베이스 예제-----------------------------------------------------------------------------------

-- 1. 특정 작성자의 이메일 주소를 모두 추출하기
SELECT `email` FROM `authorbox` INNER JOIN `emailbox` ON `authorid` = `authorbox`.`id` WHERE `name`=`Kevin Yank`;
-- 이메일을 저자박스에서 가져올거야. 이메일 박스와 조인해서 이메일박스의 authorid가 저자박스의 아이디의 같은 것을 기준
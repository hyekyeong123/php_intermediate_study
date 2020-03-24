--  룩업 테이블 만들기

CREATE TABLE `jokecategory`(
    `jokeid` INT NOT NULL, --조크 테이블의 아이디와 동일
    `categoryid` INT NOT NULL,
    PRIMARY KEY(`jokeid`,`categoryid`) --PRIMARY KEY가 2개 일수도 있구나
)DEFAULT CHARACTER SET utf8 ENGINE-InnoDB

-- 과제 1. knock-knock 카테고리에 속한 모든 유머글 가져오기
SELECT `joketext` FROM `joke` INNER JOIN `jokecategory` ON `joke`.`id` = `jokeid` INNER JOIN `category` ON `categoryid` = `category`.`id` WHERE name='knock-knock';

-- 과제 2. 본문이 'How many lawyers'로 시작하는 모든 유머글의 카테고리 목록을 가져오기
SELECT `name` FROM `category` INNER JOIN `jokecategory` ON `id` = `categoryid` INNER JOIN `joke` ON `jokeid` = `joke`.`id` WHERE `joketext` LIKE 'How many lawyers%';

-- 답
SELECT `name` FROM`joke` INNER JOIN `jokecategory` ON `jokeid` = `joke`.`id` INNER JOIN `category` ON `categoryid` = `category`.`id` WHERE `joketext` LIKE 'How many lawyers%';
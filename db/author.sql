CREATE TABLE `author`(
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255),
    `email` VARCHAR(255)
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB

-- ------------------------------------------------------------------------------
INSERT INTO `author` SET `id`=1, `name`='Kevin Yank',`email`='jhg097@naver.com';
INSERT INTO `author` SET `id`=2, `name`='Tom Butler',`email`='tom@n.je';

insert into joke
    (joketext,jokedate,authorid)
VALUES
    ("How many programs does it take to screw in a loghtblue? None,It\'s a hardware problem",'2020-03-22',1);

insert into joke
    (joketext,jokedate,authorid)
VALUES
    ("Why did the programmer quit his jop? He didn\'t gets arrays", '2017-04-01', 1);

insert into joke
    (joketext,jokedate,authorid)
VALUES
    ("Why was the empty array stuck outside> It didn\'t have any keys", '2017-04-01', 2);
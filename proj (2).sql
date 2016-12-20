-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2016 at 02:43 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `u653782861_proj`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getPostTagOfUserId`(IN `userId` INT)
    NO SQL
BEGIN
SELECT t.tag,t.tid,COUNT(tid) AS count FROM(
    SELECT
        tag,
        tid
    FROM question_tags
    INNER JOIN tags ON question_tags.tid = tags.id
    where uid=userId
    ORDER BY   tid)t GROUP BY t.tid;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getQuestionById`(IN `QUESTIONID` INT)
    NO SQL
BEGIN

  SELECT
t.title,
t.body,
MAX(CASE WHEN t.constantTagNumber = 1 THEN t.tag END) AS tag1,
MAX(CASE WHEN t.constantTagNumber = 1 THEN t.tid END) AS tid1,
MAX(CASE WHEN t.constantTagNumber = 2 THEN t.tag END) AS tag2,
MAX(CASE WHEN t.constantTagNumber = 2 THEN t.tid END) AS tid2,
MAX(CASE WHEN t.constantTagNumber = 3 THEN t.tag END) AS tag3,
MAX(CASE WHEN t.constantTagNumber = 3 THEN t.tid END) AS tid3,
MAX(CASE WHEN t.constantTagNumber = 4 THEN t.tag END) AS tag4,
MAX(CASE WHEN t.constantTagNumber = 4 THEN t.tid END) AS tid4,
MAX(CASE WHEN t.constantTagNumber = 5 THEN t.tag END) AS tag5,
MAX(CASE WHEN t.constantTagNumber = 5 THEN t.tid END) AS tid5
FROM
(
    SELECT
        questions.id AS qid,
        title,
		body,
        tags.id as tid,
        tag,
        IF (@prev = qid ,@c := @c + 1,@c := 1) constantTagNumber,
        @prev := qid
    FROM  (SELECT @prev := 0 ,@c := 1) var,
    questions LEFT JOIN
    question_tags ON questions.id=question_tags.qid
    LEFT JOIN tags ON question_tags.tid = tags.id
    WHERE questions.id= QUESTIONID
    ORDER BY    qid,tid
) t
GROUP BY t.qid ;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getQuestions`(IN `PageNumber` INT, IN `PageSize` INT, IN `filter` VARCHAR(25))
BEGIN
    Declare StartRow int;
    set StartRow = ((PageNumber - 1) * PageSize);

set @sql1=("
  SELECT
t.qid,
t.title,
t.vote,
t._views,
t.answer_count,
t.creation_date,
t.uid,
t.username,
MAX(CASE WHEN t.constantTagNumber = 1 THEN t.tag END) AS tag1,
MAX(CASE WHEN t.constantTagNumber = 1 THEN t.tid END) AS tid1,
MAX(CASE WHEN t.constantTagNumber = 2 THEN t.tag END) AS tag2,
MAX(CASE WHEN t.constantTagNumber = 2 THEN t.tid END) AS tid2,
MAX(CASE WHEN t.constantTagNumber = 3 THEN t.tag END) AS tag3,
MAX(CASE WHEN t.constantTagNumber = 3 THEN t.tid END) AS tid3,
MAX(CASE WHEN t.constantTagNumber = 4 THEN t.tag END) AS tag4,
MAX(CASE WHEN t.constantTagNumber = 4 THEN t.tid END) AS tid4,
MAX(CASE WHEN t.constantTagNumber = 5 THEN t.tag END) AS tag5,
MAX(CASE WHEN t.constantTagNumber = 5 THEN t.tid END) AS tid5
FROM
(
    SELECT
        questions.id as qid,
        title,
        creation_date,
        vote,
        _views,
        answer_count,
        tags.id as tid,
        tag,
        username,
        users.id as uid,
        IF (@prev = qid ,@c := @c + 1,@c := 1) constantTagNumber,
        @prev := qid
    FROM    (   SELECT @prev := 0 ,@c := 1) var,question_tags
    INNER JOIN tags ON question_tags.tid = tags.id
    RIGHT JOIN questions ON question_tags.qid = questions.id
    INNER JOIN users ON users.id=owner_id
    ORDER BY    qid,tid
) t
GROUP BY t.qid");
set @sql=CONCAT(@sql1," order by ",filter," desc limit ",StartRow,",",PageSize);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getQuestionsByTag`(IN `PageNumber` INT, IN `PageSize` INT, IN `tag_id` INT, IN `filter` VARCHAR(25))
    NO SQL
BEGIN
    Declare StartRow int;
    set StartRow = ((PageNumber - 1) * PageSize);
set @sql1=("
SELECT * FROM(
  SELECT
t.qid,
t.title,
t.vote,
t._views,
t.answer_count,
t.creation_date,
t.uid,
t.username,
MAX(CASE WHEN t.constantTagNumber = 1 THEN t.tag END) AS tag1,
MAX(CASE WHEN t.constantTagNumber = 1 THEN t.tid END) AS tid1,
MAX(CASE WHEN t.constantTagNumber = 2 THEN t.tag END) AS tag2,
MAX(CASE WHEN t.constantTagNumber = 2 THEN t.tid END) AS tid2,
MAX(CASE WHEN t.constantTagNumber = 3 THEN t.tag END) AS tag3,
MAX(CASE WHEN t.constantTagNumber = 3 THEN t.tid END) AS tid3,
MAX(CASE WHEN t.constantTagNumber = 4 THEN t.tag END) AS tag4,
MAX(CASE WHEN t.constantTagNumber = 4 THEN t.tid END) AS tid4,
MAX(CASE WHEN t.constantTagNumber = 5 THEN t.tag END) AS tag5,
MAX(CASE WHEN t.constantTagNumber = 5 THEN t.tid END) AS tid5
FROM
(
    SELECT
        questions.id as qid,
        title,
        creation_date,
        vote,
        _views,
        answer_count,

        tags.id as tid,
        tag,

        username,
        users.id as uid,


        IF (@prev = qid ,@c := @c + 1,@c := 1) constantTagNumber,
        @prev := qid
    FROM    (   SELECT @prev := 0 ,@c := 1) var,question_tags
    INNER JOIN tags ON question_tags.tid = tags.id
    RIGHT JOIN questions ON question_tags.qid = questions.id
    LEFT JOIN users ON users.id=owner_id
    ORDER BY    qid,tid
) t
GROUP BY t.qid ORDER BY creation_date
)g where ");
set @sql2=CONCAT(@sql1,"((tid1=",tag_id,")or(tid5=",tag_id,")or(tid4=",tag_id,")or(tid3=",tag_id,")or(tid2=",tag_id,"))");

set @sql=CONCAT(@sql2," order by ",filter," desc limit ",StartRow,",",PageSize);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTagSuggestion`(IN `tag_name` VARCHAR(50))
BEGIN

    SELECT id,tag,description FROM tags where tag LIKE CONCAT(tag_name,'%');

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loadMessages`(IN `pageNumber` INT(11), IN `pageSize` INT(11), IN `userId` INT(11), IN `friendId` INT(11))
BEGIN
    Declare startRow int;
    set startRow = ((pageNumber - 1) * pageSize);

    SELECT * FROM messages where (uid=userId and fid=friendId and udelete != 1)or(fid=userId and uid=friendId and fdelete != 1)
ORDER BY time desc LIMIT
StartRow,PageSize;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prepareTable`()
BEGIN
    DECLARE _done BOOLEAN DEFAULT FALSE;
    DECLARE _myField BIGINT DEFAULT 0;

    DEClARE _myReader CURSOR FOR
    SELECT id FROM `tags`;

    DECLARE CONTINUE HANDLER
        FOR NOT FOUND SET _done = TRUE;

 UPDATE post_counter SET tag=(SELECT COUNT(id) FROM tags),
 question=(SELECT COUNT(id) FROM questions WHERE deleted!=1);

  DROP TABLE IF EXISTS `tag_similarity`;

    CREATE TABLE `tag_similarity` (
        `tag` FLOAT UNSIGNED PRIMARY KEY
    );

    OPEN _myReader;

    myLoop: LOOP

        FETCH _myReader INTO _myField;

        IF _done = 1 THEN
            LEAVE myLoop;
        END IF;


        INSERT INTO `tag_similarity` (tag) VALUES (_myField);
        SET @sql = CONCAT('ALTER TABLE tag_similarity ADD `',_myfield,'` DOUBLE DEFAULT 0');
      PREPARE stmt FROM @sql;
         EXECUTE stmt ;
         DEALLOCATE PREPARE stmt;
      END LOOP myLoop;

    CLOSE _myReader;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sample`()
    NO SQL
BEGIN
SELECT
MAX(CASE WHEN (t.ct = 5 and t.x>0) THEN t.uid END) AS user_id
FROM
(
    SELECT
        uid,
        fseen,
        IF (@prev = uid ,@c := @c + 1,@c := 1) ct,
        @prev := uid,
        IF ( (@pf = 'hello' && @pv=uid) ,@a := @a + 1,@a := 0) x,
        @pf := message,@pv:=uid
    FROM    (SELECT @prev := 0 ,@c := 1,@pf := 0 ,@a := 0,@pv:=0) var,
    messages
    order by uid asc,time desc
) t
GROUP BY t.uid ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchPost`(IN `query` TEXT)
    NO SQL
Begin
select * from questions where MATCH (title) AGAINST (query);
End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAnswerCount`(IN `qid` INT, IN `flag` INT)
    NO SQL
BEGIN

 if(flag=1)
 then
 UPDATE questions SET answer_count=answer_count+1 where id=qid;
 else
 UPDATE questions SET answer_count=answer_count-1 where id=qid;
 end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateQuestionViews`(IN `qid` INT)
    NO SQL
BEGIN
UPDATE questions SET _views=_views+1 WHERE id=qid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateSeen`(IN `PageNumber` INT, IN `PageSize` INT, IN `userId` INT, IN `friendId` INT)
BEGIN
    DECLARE mid BIGINT;
    Declare startRow int;
    set startRow = ((pageNumber - 1) * pageSize);

      SELECT id into mid
      FROM messages
      where (uid=userId and fid=friendId and udelete != 1)
      or
      (fid=userId and uid=friendId and fdelete != 1)
      ORDER BY time desc
      LIMIT StartRow,PageSize;

    UPDATE messages SET fseen = 1 WHERE id = mid;




 END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `qid` bigint(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` bigint(20) DEFAULT NULL,
  `body` text NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vote` bigint(20) NOT NULL DEFAULT '0',
  `last_edited_date` varchar(250) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=195 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `qid` bigint(20) DEFAULT NULL,
  `aid` bigint(20) DEFAULT NULL,
  `body` varchar(250) NOT NULL,
  `time` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=197 ;

-- --------------------------------------------------------

--
-- Table structure for table `favourite_question`
--

CREATE TABLE IF NOT EXISTS `favourite_question` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `qid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=134 ;

-- --------------------------------------------------------

--
-- Table structure for table `friends_questions`
--

CREATE TABLE IF NOT EXISTS `friends_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL,
  `fid` bigint(20) DEFAULT NULL,
  `qid` bigint(20) DEFAULT NULL,
  `follow` tinyint(1) NOT NULL DEFAULT '0',
  `block` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `time` int(50) NOT NULL,
  `fdelete` int(11) NOT NULL,
  `udelete` int(11) NOT NULL,
  `fseen` tinyint(1) NOT NULL DEFAULT '0',
  `notified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=888 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_activity`
--

CREATE TABLE IF NOT EXISTS `message_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(30) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL DEFAULT '0',
  `aid` int(11) NOT NULL DEFAULT '0',
  `qid` int(11) NOT NULL DEFAULT '0',
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `fid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_counter`
--

CREATE TABLE IF NOT EXISTS `post_counter` (
  `tag` int(11) NOT NULL DEFAULT '0',
  `question` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `vote` bigint(20) NOT NULL DEFAULT '0',
  `last_edited_user_id` bigint(20) NOT NULL,
  `accepted_answer_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_activity_date` timestamp NOT NULL,
  `closed_date` varchar(50) NOT NULL,
  `deletion_date` varchar(50) NOT NULL,
  `answer_count` smallint(6) NOT NULL,
  `comment_count` smallint(6) NOT NULL,
  `favorite_count` bigint(20) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `_views` bigint(20) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`title`,`body`(767),`owner_id`,`vote`,`last_edited_user_id`,`accepted_answer_id`,`creation_date`,`last_activity_date`,`closed_date`,`deletion_date`,`answer_count`,`comment_count`,`favorite_count`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `body` (`body`),
  FULLTEXT KEY `title_2` (`title`),
  FULLTEXT KEY `body_2` (`body`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=372 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_tags`
--

CREATE TABLE IF NOT EXISTS `question_tags` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `qid` bigint(20) NOT NULL,
  `tid` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=700 ;

-- --------------------------------------------------------

--
-- Table structure for table `reported_contents`
--

CREATE TABLE IF NOT EXISTS `reported_contents` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL,
  `aid` bigint(20) DEFAULT NULL,
  `qid` bigint(20) DEFAULT NULL,
  `message` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tagclusters`
--

CREATE TABLE IF NOT EXISTS `tagclusters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` bigint(20) unsigned DEFAULT NULL,
  `cluster` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag` varchar(25) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `maxpost` bigint(20) NOT NULL,
  `followers` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `tag` (`tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=189 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag_similarity`
--

CREATE TABLE IF NOT EXISTS `tag_similarity` (
  `tag` float unsigned NOT NULL,
  `123` double DEFAULT '0',
  `124` double DEFAULT '0',
  `125` double DEFAULT '0',
  `126` double DEFAULT '0',
  `127` double DEFAULT '0',
  `128` double DEFAULT '0',
  `129` double DEFAULT '0',
  `130` double DEFAULT '0',
  `131` double DEFAULT '0',
  `132` double DEFAULT '0',
  `133` double DEFAULT '0',
  `134` double DEFAULT '0',
  `135` double DEFAULT '0',
  `136` double DEFAULT '0',
  `137` double DEFAULT '0',
  `138` double DEFAULT '0',
  `139` double DEFAULT '0',
  `140` double DEFAULT '0',
  `141` double DEFAULT '0',
  `142` double DEFAULT '0',
  `143` double DEFAULT '0',
  `144` double DEFAULT '0',
  `145` double DEFAULT '0',
  `146` double DEFAULT '0',
  `147` double DEFAULT '0',
  `148` double DEFAULT '0',
  `149` double DEFAULT '0',
  `150` double DEFAULT '0',
  `151` double DEFAULT '0',
  `152` double DEFAULT '0',
  `153` double DEFAULT '0',
  `154` double DEFAULT '0',
  `155` double DEFAULT '0',
  `156` double DEFAULT '0',
  `157` double DEFAULT '0',
  `158` double DEFAULT '0',
  `159` double DEFAULT '0',
  `160` double DEFAULT '0',
  `161` double DEFAULT '0',
  `162` double DEFAULT '0',
  `163` double DEFAULT '0',
  `164` double DEFAULT '0',
  `165` double DEFAULT '0',
  `166` double DEFAULT '0',
  `167` double DEFAULT '0',
  `168` double DEFAULT '0',
  `169` double DEFAULT '0',
  `170` double DEFAULT '0',
  `171` double DEFAULT '0',
  `172` double DEFAULT '0',
  `173` double DEFAULT '0',
  `174` double DEFAULT '0',
  `176` double DEFAULT '0',
  `177` double DEFAULT '0',
  `178` double DEFAULT '0',
  `179` double DEFAULT '0',
  `180` double DEFAULT '0',
  `181` double DEFAULT '0',
  `182` double DEFAULT '0',
  `183` double DEFAULT '0',
  `184` double DEFAULT '0',
  `185` double DEFAULT '0',
  `186` double DEFAULT '0',
  `187` double DEFAULT '0',
  `188` double DEFAULT '0',
  PRIMARY KEY (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `aboutme` varchar(255) NOT NULL DEFAULT 'Apparently, this user prefers to keep an air of mystery about them',
  `joined_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `followers_num` bigint(20) NOT NULL,
  `profile_image` varchar(250) DEFAULT 'users/profile_images/default.jpg',
  `status` tinyint(4) DEFAULT '1',
  `active` char(32) NOT NULL DEFAULT '1',
  `reputation` bigint(20) NOT NULL DEFAULT '0',
  `moderator` int(11) NOT NULL DEFAULT '0',
  `admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_tags`
--

CREATE TABLE IF NOT EXISTS `user_tags` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `tid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_tag_score`
--

CREATE TABLE IF NOT EXISTS `user_tag_score` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `tid` bigint(20) NOT NULL,
  `score` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=158 ;

-- --------------------------------------------------------

--
-- Table structure for table `vote_details`
--

CREATE TABLE IF NOT EXISTS `vote_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `qid` int(11) DEFAULT NULL,
  `aid` bigint(20) DEFAULT NULL,
  `up` int(11) NOT NULL DEFAULT '0',
  `down` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=778 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reported_contents`
--
ALTER TABLE `reported_contents`
  ADD CONSTRAINT `reported_contents_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD CONSTRAINT `user_tags_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_tags_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vote_details`
--
ALTER TABLE `vote_details`
  ADD CONSTRAINT `vote_details_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.36-community-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema idea
--



--
-- Definition of table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `content` varchar(200) NOT NULL,
  `status` varchar(45) NOT NULL,
  `idea_id` int(10) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned DEFAULT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comments_1` (`idea_id`),
  CONSTRAINT `FK_comments_1` FOREIGN KEY (`idea_id`) REFERENCES `ideas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;


--
-- Definition of table `favorites_ideas`
--

DROP TABLE IF EXISTS `favorites_ideas`;
CREATE TABLE `favorites_ideas` (
  `user_id` int(10) unsigned NOT NULL,
  `idea_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`idea_id`),
  KEY `FK_favorites_ideas_2` (`idea_id`),
  CONSTRAINT `FK_favorites_ideas_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_favorites_ideas_2` FOREIGN KEY (`idea_id`) REFERENCES `ideas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favorites_ideas`
--



--
-- Definition of table `friends`
--

DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `friend_id` int(10) unsigned NOT NULL,
  `create_time` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_friends_1` (`user_id`),
  KEY `FK_friends_2` (`friend_id`),
  CONSTRAINT `FK_friends_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_friends_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--


--
-- Definition of table `friends_groups`
--

DROP TABLE IF EXISTS `friends_groups`;
CREATE TABLE `friends_groups` (
  `friend_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`friend_id`,`group_id`) USING BTREE,
  KEY `FK_friends_groups_1` (`group_id`),
  CONSTRAINT `FK_friends_groups_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_friends_groups_2` FOREIGN KEY (`friend_id`) REFERENCES `friends` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends_groups`
--



--
-- Definition of table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_groups_1` (`user_id`),
  CONSTRAINT `FK_groups_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--



--
-- Definition of table `groups_ideas`
--

DROP TABLE IF EXISTS `groups_ideas`;
CREATE TABLE `groups_ideas` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idea_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`group_id`,`idea_id`),
  KEY `FK_groups_ideas_2` (`idea_id`),
  CONSTRAINT `FK_groups_ideas_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_groups_ideas_2` FOREIGN KEY (`idea_id`) REFERENCES `ideas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups_ideas`
--



--
-- Definition of table `ideas`
--

DROP TABLE IF EXISTS `ideas`;
CREATE TABLE `ideas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idea` varchar(200) NOT NULL,
  `status` varchar(45) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `is_public` tinyint(1) NOT NULL,
  `comment_id` int(10) unsigned DEFAULT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ideas_1` (`author_id`),
  KEY `FK_ideas_2` (`comment_id`),
  CONSTRAINT `FK_ideas_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_ideas_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ideas`
--



--
-- Definition of table `lookups`
--

DROP TABLE IF EXISTS `lookups`;
CREATE TABLE `lookups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  `position` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lookups`
--

/*!40000 ALTER TABLE `lookups` DISABLE KEYS */;
INSERT INTO `lookups` (`id`,`name`,`code`,`type`,`position`) VALUES 
 (1,'Draft','1','IdeasStatus',1),
 (2,'Published','2','IdeasStatus',2),
 (3,'Archived','3','IdeasStatus - Deprecated',3),
 (4,'Pending Approval','1','CommentsStatus',1),
 (5,'Approved','2','CommentsStatus',2);
/*!40000 ALTER TABLE `lookups` ENABLE KEYS */;


--
-- Definition of table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `about` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profiles`
--

/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` (`user_id`,`lastname`,`firstname`,`about`) VALUES 
 (1,'Admin','Administrator','');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;


--
-- Definition of table `profiles_fields`
--

DROP TABLE IF EXISTS `profiles_fields`;
CREATE TABLE `profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL,
  `range` varchar(255) NOT NULL,
  `error_message` varchar(255) NOT NULL,
  `other_validator` varchar(255) NOT NULL,
  `default` varchar(255) NOT NULL,
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`visible`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profiles_fields`
--

/*!40000 ALTER TABLE `profiles_fields` DISABLE KEYS */;
INSERT INTO `profiles_fields` (`id`,`varname`,`title`,`field_type`,`field_size`,`field_size_min`,`required`,`match`,`range`,`error_message`,`other_validator`,`default`,`position`,`visible`) VALUES 
 (1,'lastname','Last Name','INT',50,3,1,'','','Incorrect Last Name (length between 3 and 50 characters).','','',1,3),
 (2,'firstname','First Name','INT',50,3,1,'','','Incorrect First Name (length between 3 and 50 characters).','','',0,3),
 (3,'about','About me','TEXT',1500,0,0,'','','','','',10,0);
/*!40000 ALTER TABLE `profiles_fields` ENABLE KEYS */;


--
-- Definition of table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `frequency` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(10) NOT NULL DEFAULT '0',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`username`,`password`,`email`,`activkey`,`createtime`,`lastvisit`,`superuser`,`status`) VALUES 
 (1,'admin','21232f297a57a5a743894a0e4a801fc3','webmaster@example.com','9a24eff8c15a6a141ece27eb6947da0f',1261146094,1280187353,1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


--
-- Definition of table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

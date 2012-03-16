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

CREATE DATABASE IF NOT EXISTS idea;
USE idea;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`,`email`,`content`,`status`,`idea_id`,`create_time`,`author_id`,`rank`) VALUES 
 (1,'tanto@tanto.com','sin liquido','2',3,1270253625,2,0),
 (2,'tanto@tanto.com','sin liquido','2',3,1270253651,2,0),
 (3,'ergo@sum.com','el clan, el clan','2',8,1270344199,2,5),
 (4,'camino@largo.com','para caminar','2',8,1270344267,2,7),
 (5,'demo@example.com','habia olvidado','2',8,1270345671,2,3),
 (6,'webmaster@example.com','con pinky','2',2,1270410776,1,0),
 (7,'webmaster@example.com','comentarios','2',9,1270428113,1,0),
 (8,'webmaster@example.com','carreñon','2',11,1270429940,1,0),
 (9,'webmaster@example.com','pues ya esta','2',11,1270430016,1,2),
 (10,'webmaster@example.com','un comentarios','2',19,1270906679,1,1),
 (11,'demo@example.com','jugando','2',2,1271286305,2,0),
 (12,'demo@example.com','saltando','2',2,1271286453,2,0),
 (13,'webmaster@example.com','siempre hay una buena cancion','2',18,1271518674,1,-2),
 (14,'jluna79@gmail.com','mmmh no entiendo','2',18,1271712137,5,1);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;


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

/*!40000 ALTER TABLE `favorites_ideas` DISABLE KEYS */;
INSERT INTO `favorites_ideas` (`user_id`,`idea_id`) VALUES 
 (1,2),
 (1,9),
 (2,30),
 (1,31);
/*!40000 ALTER TABLE `favorites_ideas` ENABLE KEYS */;


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

/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` (`id`,`user_id`,`friend_id`,`create_time`) VALUES 
 (1,1,3,'1271023607'),
 (4,1,2,'1271112659'),
 (5,2,1,'1271628616'),
 (6,5,1,'1271717819');
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;


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

/*!40000 ALTER TABLE `friends_groups` DISABLE KEYS */;
INSERT INTO `friends_groups` (`friend_id`,`group_id`) VALUES 
 (6,5),
 (1,6);
/*!40000 ALTER TABLE `friends_groups` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`,`user_id`,`name`) VALUES 
 (5,5,'GrupoDeToby'),
 (6,1,'nuevo'),
 (7,1,'viejo');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups_ideas`
--

/*!40000 ALTER TABLE `groups_ideas` DISABLE KEYS */;
INSERT INTO `groups_ideas` (`group_id`,`idea_id`) VALUES 
 (6,29),
 (6,30),
 (7,30),
 (5,31);
/*!40000 ALTER TABLE `groups_ideas` ENABLE KEYS */;


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
  PRIMARY KEY (`id`),
  KEY `FK_ideas_1` (`author_id`),
  KEY `FK_ideas_2` (`comment_id`),
  CONSTRAINT `FK_ideas_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  CONSTRAINT `FK_ideas_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ideas`
--

/*!40000 ALTER TABLE `ideas` DISABLE KEYS */;
INSERT INTO `ideas` (`id`,`idea`,`status`,`tags`,`author_id`,`create_time`,`update_time`,`is_public`,`comment_id`) VALUES 
 (2,'Como conquistar el mundo','2','Como, mundo, conquistar',1,1270238620,1271518442,1,NULL),
 (3,'mejorando la coca cola','2','cocacola, botella',1,1270240742,1270240742,1,NULL),
 (4,'I can buggy?','1','all, night, long',1,1270341164,1270341164,1,NULL),
 (5,'gusana ciega','1','gusana, ciega, cuatro, cinco',1,1270341257,1270341257,1,NULL),
 (6,'nadie me hable','1','luna, lugar',1,1270341391,1270341391,1,NULL),
 (7,'creyendo','1','nadie, dolor, gusana',1,1270341414,1270341414,1,NULL),
 (8,'clan, clan','2','ignorar',1,1270341651,1270341727,1,NULL),
 (9,'Carreño','2','sincero',2,1270424056,1271518448,1,NULL),
 (10,'drafti','1','drafti, style',2,1270424088,1270424088,1,NULL),
 (11,'publica y publicada','2','yay, publica',1,1270428342,1270428342,1,NULL),
 (12,'publicoooooo','1','vamos, public, guarda',1,1270429039,1270429039,1,NULL),
 (13,'publicoooooo11111111111','1','ergo, sum',1,1270429058,1270429058,1,NULL),
 (14,'puedo ver el insert','1','puedo o no puedo',1,1270429082,1270429082,1,NULL),
 (15,'rompete','1','quiero, ver, que, viaja',1,1270429125,1270429125,1,NULL),
 (16,'rompete1111','1','please',1,1270429240,1270429240,1,NULL),
 (17,'rompete11112222','1','please, asi',1,1270429417,1270429417,1,NULL),
 (18,'rompete11112222publico','2','please, asi',1,1270429441,1271719749,1,NULL),
 (19,'te quiero','2','te, llevaste, marzo',3,1270765344,1270765344,1,NULL),
 (20,'no habia','2','hello',1,1271699582,1271699582,0,NULL),
 (21,'labios','2','megafono',1,1271700327,1271700327,0,NULL),
 (22,'labios','2','megafono',1,1271700345,1271700345,0,NULL),
 (23,'labios','2','megafono',1,1271700380,1271700380,0,NULL),
 (24,'labios','2','megafono',1,1271703479,1271703479,0,NULL),
 (25,'mujer','2','hola',1,1271703917,1271703917,0,NULL),
 (26,'mujer','2','hola',1,1271703987,1271703987,0,NULL),
 (27,'twist','2','acapulco',1,1271704059,1271704059,0,NULL),
 (28,'yaya','2','toure',1,1271704083,1271704083,0,NULL),
 (29,'yaya heyo','2','toure',1,1271704489,1271723155,0,NULL),
 (30,'bailando','2','lados',1,1271704520,1271722547,0,NULL),
 (31,'Es esta una buena idea?','2','buena, idea, misideas',5,1271718003,1271718003,1,NULL),
 (32,'comentarios','2','sincero',1,1271879408,1271879408,1,NULL),
 (33,'mmmh no entiendo','2','please, asi',1,1271879903,1271879903,1,NULL),
 (34,'saltando','2','Como, mundo, conquistar',1,1271880030,1271880030,1,NULL),
 (35,'siempre hay una buena cancion','2','please, asi',2,1271880173,1271880173,1,13);
/*!40000 ALTER TABLE `ideas` ENABLE KEYS */;


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
 (1,'Admin','Administrator',''),
 (2,'Demo','Demo',''),
 (3,'demo','DEMO',''),
 (4,'yo','yo',''),
 (5,'Luna','Jorge','');
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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` (`id`,`name`,`frequency`) VALUES 
 (1,'Como',2),
 (2,'mundo',2),
 (3,'conquistar',2),
 (4,'cocacola',1),
 (5,'botella',1),
 (6,'all',1),
 (7,'night',1),
 (8,'long',1),
 (9,'gusana',2),
 (10,'ciega',1),
 (11,'cuatro',1),
 (12,'cinco',1),
 (13,'luna',1),
 (14,'lugar',1),
 (15,'nadie',1),
 (16,'dolor',1),
 (17,'ignorar',1),
 (18,'sincero',2),
 (19,'drafti',1),
 (20,'style',1),
 (21,'yay',1),
 (22,'publica',1),
 (23,'vamos',1),
 (24,'public',1),
 (25,'guarda',1),
 (26,'ergo',1),
 (27,'sum',1),
 (28,'puedo o no puedo',1),
 (29,'quiero',1),
 (30,'ver',1),
 (31,'que',1),
 (32,'viaja',1),
 (33,'please',5),
 (34,'asi',4),
 (35,'te',1),
 (36,'llevaste',1),
 (37,'marzo',1),
 (38,'hello',1),
 (39,'megafono',3),
 (40,'hola',2),
 (41,'acapulco',1),
 (42,'toure',3),
 (43,'lados',2),
 (44,'buena',2),
 (45,'idea',2),
 (46,'misideas',2);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`username`,`password`,`email`,`activkey`,`createtime`,`lastvisit`,`superuser`,`status`) VALUES 
 (1,'admin','21232f297a57a5a743894a0e4a801fc3','webmaster@example.com','9a24eff8c15a6a141ece27eb6947da0f',1261146094,1271877273,1,1),
 (2,'demo','fe01ce2a7fbac8fafaed7c982a04e229','demo@example.com','099f825543f7850cc038b90aaff39fac',1261146094,1271880129,0,1),
 (3,'demo2','fe01ce2a7fbac8fafaed7c982a04e229','demo@demo.com','d5a6e0ddb0ad538d2215fabf8e4aef14',1270764973,1270765248,0,1),
 (4,'yo1','b07e1c6c4d5e9fa96c752672b971666f','yo@yo.com','2102d36e740cb3c54784284113088ff8',1271711693,1271711716,0,1),
 (5,'jluna','e970aae8e362daefe2eb6cfe733bd066','jluna79@gmail.com','105cb86a1b28dc65f9670208467c9909',1271711840,1271711993,0,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


--
-- Definition of table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--

/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
INSERT INTO `votes` (`user_id`,`comment_id`) VALUES 
 (1,3),
 (1,4),
 (1,5),
 (1,7),
 (1,8),
 (1,9),
 (1,10),
 (1,13),
 (2,7),
 (2,8),
 (2,9),
 (5,13),
 (5,14);
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

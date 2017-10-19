/*
SQLyog Community v11.11 (32 bit)
MySQL - 5.1.53-community-log : Database - nite
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`nite` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `nite`;

/*Table structure for table `account` */

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `gender` int(1) NOT NULL DEFAULT '1',
  `avatar` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `social_type` varchar(50) NOT NULL,
  `social_id` varchar(100) NOT NULL,
  `userCategory` varchar(50) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1',
  `active` int(1) NOT NULL DEFAULT '1',
  `stream_life` int(3) NOT NULL DEFAULT '60',
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `account` */

insert  into `account`(`id`,`firstName`,`lastName`,`userName`,`gender`,`avatar`,`password`,`email`,`social_type`,`social_id`,`userCategory`,`state`,`active`,`stream_life`,`created`) values (1,'boris','roshkov','boris',1,'yeQwR0dIZxY6Kgtd.jpg','e10adc3949ba59abbe56e057f20f883e','boris@gmail.com','','','Nite Streamer',1,1,44,'1445720369'),(2,'','','Black',1,'i5WUGrjdBK8JxXsL.jpg','e10adc3949ba59abbe56e057f20f883e','black@gmail.com','','','user',1,1,60,'1460347564'),(3,'','','good',0,'faPmg5RwLBXiMG0A.jpg','e10adc3949ba59abbe56e057f20f883e','good@gmail.com','','','Nite Streamer',1,1,52,'1460359159'),(4,'','','happy',1,'LMQEni58BB0vpFir.jpg','e10adc3949ba59abbe56e057f20f883e','happy@gmail.com','','','Artist',1,1,60,'1460411204'),(5,'','','LiChuan2014',1,'6bEZPUwPWrwYnCJC.jpg','','xin@gmail.com','twitter','2278916394','Nite Streamer',1,1,60,'1460413036');

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `permission` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `admin` */

insert  into `admin`(`id`,`username`,`password`,`permission`) values (1,'admin','123456',1);

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `catName` varchar(100) NOT NULL,
  `descr` varchar(500) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1',
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`id`,`icon`,`image`,`catName`,`descr`,`state`,`created`) values (1,'ppuSl08X.png','npvGepdc.jpg','funny video','All people like this.',1,'');

/*Table structure for table `chat` */

DROP TABLE IF EXISTS `chat`;

CREATE TABLE `chat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sender_id` bigint(20) NOT NULL,
  `receiver_id` bigint(20) NOT NULL,
  `media_type` varchar(30) NOT NULL DEFAULT 'text',
  `message` text NOT NULL,
  `link` varchar(250) NOT NULL,
  `checked` int(1) NOT NULL DEFAULT '0',
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `chat` */

insert  into `chat`(`id`,`sender_id`,`receiver_id`,`media_type`,`message`,`link`,`checked`,`created`) values (1,3,2,'text','Hello, how are you?','',1,'1460371929'),(2,1,2,'text','Hi','',1,'1460372675'),(3,3,1,'text','Hello?','',1,'1460372687'),(4,3,2,'text','Renewed we\'re','',1,'1460372853'),(5,4,2,'text','Hi','',1,'1460381835'),(6,1,3,'video','','RbAqa6iZlSyRDau2.mov',1,'1461976445'),(7,1,3,'photo','','n6l1qCHBZK0cBLJt.jpg',1,'1461978329'),(8,1,3,'text','Hi','',1,'1461978350'),(9,1,3,'photo','','4syY5jOf9UWuSyLr.jpg',1,'1461995352'),(10,1,3,'text','How are you? Are you still there?','',1,'1461995491'),(11,1,3,'video','','yonuAE5eSez2nfFL.mov',1,'1462015438'),(12,1,3,'video','','fN7S3NEjNktze7ma.mov',1,'1462015451'),(13,1,3,'text','Hi','',1,'1462821403'),(14,1,2,'text','Hello, this is test message','',1,'1463045043'),(15,1,3,'text','Hello this is message','',0,'1463045075'),(16,1,4,'text','Hello this is test message','',1,'1463045112'),(17,1,4,'text','Staffs staff','',1,'1463046801');

/*Table structure for table `comment_stream` */

DROP TABLE IF EXISTS `comment_stream`;

CREATE TABLE `comment_stream` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `streamID` int(10) NOT NULL,
  `message` varchar(255) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1',
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `comment_stream` */

insert  into `comment_stream`(`id`,`account_id`,`streamID`,`message`,`state`,`created`) values (1,1,23,'Hi',1,'1462828347'),(2,1,23,'Hello',1,'1462828354'),(3,1,23,'Hi',1,'1462828552'),(4,1,23,'Amaing.  Ghh hi',1,'1462828559'),(5,1,23,'Hi',1,'1462828638'),(6,1,23,'Amazing',1,'1462828643'),(7,1,23,'Yyyyuu fugue hbububj hbububj u hbububj hbububj ububu ububu ububu u u ububu',1,'1462828683'),(8,1,23,'Hi',1,'1462828689'),(9,1,23,'Bhjhhhhghhhbghjvg jinn in in hh hi hjn',1,'1462828698'),(10,1,23,'Nikon hjn hhbhuttvhuhh vybvuhbhuguvyvhvuvubbubu',1,'1462828719'),(11,1,23,'Hi',1,'1462828984'),(12,1,23,'Hello',1,'1463048389'),(13,1,23,'Gggg',1,'1463048405');

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stream_id` bigint(20) NOT NULL,
  `account_id` int(10) NOT NULL,
  `message` varchar(500) NOT NULL,
  `created` varchar(10) NOT NULL,
  `media_type` varchar(10) NOT NULL,
  `media_link` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `comments` */

insert  into `comments`(`id`,`stream_id`,`account_id`,`message`,`created`,`media_type`,`media_link`) values (1,1,1,'this is test comment','1460348586','text',''),(2,1,3,'hello?','1460396911','text',''),(3,1,3,'hi, there?','1460397055','text',''),(4,1,3,'are you there?','1460397706','text',''),(5,1,3,'i am waiting for your reply, please reply to me, please please please please please please plepase','1460397721','text',''),(6,1,3,'hi','1460399270','text',''),(7,1,3,'llkjhkjhkj kjh kjhkj kjh kjhjk hkj','1460399277','text',''),(8,1,1,'','1462002402','photo','qTvbqlsTV7Ab4HmZ.jpg'),(9,1,1,'','1462005075','photo','SRm4yJl9DtTCXc1S.jpg'),(10,1,1,'','1462005424','photo','tze7maKX8MNcceHS.jpg'),(11,1,1,'','1462013073','',''),(12,1,1,'','1462013230','',''),(13,1,1,'','1462013314','video','IRzAx3WPiw4RGV3L.mov'),(14,1,1,'','1462013347','',''),(15,1,1,'','1462015295','video','VTMppDP2VDK6U4rM.mov'),(16,1,1,'','1462015320','',''),(17,1,1,'','1462015357','',''),(18,1,1,'','1462015406','',''),(19,1,3,'','1462015824','video','nSxdKuOwyuw85vgN.mov'),(20,1,3,'','1462015887','video','TxDQXSdT5NWGSDy1.mov'),(21,1,3,'','1462015918','video','VvaQaySjWKBdfTqN.mov'),(22,1,3,'','1462015943','video','sM3eTSshJkwDjgJR.mov');

/*Table structure for table `device` */

DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `account_id` bigint(20) NOT NULL,
  `device_type` varchar(100) NOT NULL DEFAULT 'ios',
  `device_id` varchar(500) NOT NULL,
  `access_token` varchar(100) NOT NULL,
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `access_token` (`access_token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `device` */

insert  into `device`(`account_id`,`device_type`,`device_id`,`access_token`,`created`) values (2,'ios','ios_123456','X7l6O8xNUADZJKjVpEDWUxuTG6XgeiH2','1460347629'),(1,'ios','fa33cdfdd1cbc98956b61cd8153265b2d2342efd1959c4486ef4e594795c403f','Nb2M4xoQ2IPHd7t0jLplfULJIV2Xvrxe','1460345629'),(3,'ios','1234567890','JBYWFwfGd2LE49uwbWDJstbryTvVUxWl','1460359289'),(4,'ios','1234567892','0JcAQ5PXlajRTJh7REsGznN8yznOiGDI','1460411236'),(5,'ios','1234567894','PZNM7TefSE5eqLlV7lIzZylH6vm8z6Qj','1460413069');

/*Table structure for table `follow` */

DROP TABLE IF EXISTS `follow`;

CREATE TABLE `follow` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `follow_id` int(10) NOT NULL,
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_id` (`account_id`,`follow_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `follow` */

insert  into `follow`(`id`,`account_id`,`follow_id`,`created`) values (1,2,3,''),(2,3,1,''),(3,3,2,''),(4,1,2,''),(5,1,5,'');

/*Table structure for table `join_stream` */

DROP TABLE IF EXISTS `join_stream`;

CREATE TABLE `join_stream` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `streamID` int(10) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1',
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `join_stream` */

insert  into `join_stream`(`id`,`account_id`,`streamID`,`state`,`created`) values (1,1,23,1,'1462828090'),(2,1,23,1,'1462828268'),(3,1,23,1,'1462828339'),(4,1,23,1,'1462828549'),(5,1,23,1,'1462828635'),(6,1,23,1,'1462828674'),(7,1,23,1,'1462828979'),(8,1,23,1,'1463044870'),(9,1,23,1,'1463046378'),(10,1,23,1,'1463048378'),(11,1,23,1,'1463049610');

/*Table structure for table `live_stream` */

DROP TABLE IF EXISTS `live_stream`;

CREATE TABLE `live_stream` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `streamID` varchar(50) NOT NULL,
  `account_id` int(10) NOT NULL,
  `state` int(1) NOT NULL,
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

/*Data for the table `live_stream` */

insert  into `live_stream`(`id`,`streamID`,`account_id`,`state`,`created`) values (2,'zOgwluB3xK',1,0,'1461924242'),(3,'Jsh1Oy69am',1,0,'1461925020'),(4,'PUE0Cl2xRv',1,0,'1461925205'),(5,'07im0JWoci',1,0,'1461925407'),(6,'nBPxZbsOG9',1,0,'1461925486'),(7,'GDuy9xlzLF',1,0,'1462013462'),(8,'CfNn85Eddq',1,0,'1462013682'),(9,'RI8EPcC0bH',1,0,'1462014724'),(10,'YcICTN33yd',1,0,'1462015769'),(11,'3TzdDjhuko',3,0,'1462016139'),(12,'U2wEwgSETL',3,0,'1462016441'),(13,'00FbPlTTzw',3,0,'1462016607'),(14,'XjrbH7RKqM',3,0,'1462016809'),(15,'tbxKHHEUTT',3,0,'1462017264'),(16,'rQzsDNcJJJ',3,0,'1462017433'),(17,'EWB1e7AI72',3,0,'1462017535'),(18,'q8LZ8dug6j',3,0,'1462017586'),(19,'k0KjP5j6JA',1,0,'1462818193'),(20,'LvnvHTiJ9Q',1,0,'1462818216'),(21,'aW2v2LESqg',1,0,'1462818320'),(22,'QudFxmUHf2',1,0,'1462818652'),(23,'123456',3,1,'1462818773'),(24,'1K35z84WVT',1,0,'1462828964'),(25,'7AgonumWIA',1,0,'1463048573'),(26,'fNhlGsvdL7',1,0,'1463048796'),(27,'m4yJl9DtTC',1,0,'1464713417'),(28,'Xc1SnSxdKu',1,0,'1464713623'),(29,'Owyuw85vgN',1,0,'1464714256'),(30,'TxDQXSdT5N',1,0,'1464715057'),(31,'WGSDy1VvaQ',1,0,'1464715196'),(32,'DutNRdm2es',1,0,'1464720654'),(33,'NFddFlnLUm',1,0,'1464720709'),(34,'zdDjhukolI',1,0,'1464720916'),(35,'iKYcJnlbXj',1,0,'1464721025'),(36,'rbH7RKqMZ1',1,0,'1464721181'),(37,'6VsML1RbTn',1,0,'1464722682'),(38,'qRoNC8Ch6K',1,0,'1464723178'),(39,'zEbJ1xLmcL',1,0,'1464723383'),(40,'PwfLOWTRNk',1,0,'1464723560'),(41,'mwncju8he7',1,0,'1464723738'),(42,'mCdlc4HZyl',1,0,'1464725104'),(43,'gmhHQ785ck',1,0,'1464725939'),(44,'78rQzsDNcJ',1,0,'1464726102'),(45,'JJJvDRwdXU',1,0,'1464726286'),(46,'vtHUWCowUS',1,0,'1464727346'),(47,'qxMgspHjLj',1,0,'1464727918'),(48,'Pr9dJmY16i',1,0,'1464728181'),(49,'ToLOEWB1e7',1,0,'1464728558'),(50,'AI72QTQGWF',1,0,'1464729246'),(51,'wHYrW392U1',1,0,'1464729510'),(52,'LwiBlLVzWR',1,0,'1464729642'),(53,'jRBxjyq8LZ',1,0,'1464730132'),(54,'8dug6jIJK9',1,0,'1464730536'),(55,'GRcfm1EhSE',1,0,'1464734616'),(56,'r4OLNjB46B',1,0,'1464737076'),(57,'ubqNAh1n5Y',1,0,'1464737884'),(58,'POBtOecwoW',1,0,'1464738118'),(59,'yOzUKUnWHx',1,0,'1464740695'),(60,'B0W9TEYVqk',1,0,'1464741129'),(61,'lErRUodWaC',1,0,'1464741421'),(62,'liOsLElnwn',1,0,'1464742067'),(63,'2Qgc1k0Q6E',1,0,'1464742764'),(64,'QR7p8MN1KQ',1,0,'1464742956'),(65,'JBqsD5GMAi',1,0,'1464787341'),(66,'DOWZnB7bbS',1,0,'1464787611'),(67,'Mqe86XatD0',1,0,'1464788808'),(68,'FdizGvYoOu',1,0,'1464789765'),(69,'oq9FobViNT',1,0,'1464790250'),(70,'kcyW5qYMAi',1,0,'1464790710'),(71,'c6I57H0FV4',1,0,'1464790862');

/*Table structure for table `noti` */

DROP TABLE IF EXISTS `noti`;

CREATE TABLE `noti` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `receiver_id` int(10) NOT NULL,
  `info_id` int(10) NOT NULL,
  `noti_type` varchar(50) NOT NULL,
  `message` varchar(100) NOT NULL,
  `checked` int(1) NOT NULL DEFAULT '0',
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `noti` */

insert  into `noti`(`id`,`account_id`,`receiver_id`,`info_id`,`noti_type`,`message`,`checked`,`created`) values (1,2,3,0,'follow','Black followed you.',1,'1460347994'),(2,3,1,0,'follow','good followed you.',1,'1460363977'),(3,3,2,0,'follow','good followed you.',0,'1460364914'),(4,3,2,0,'chat','good messaged you.',0,'1460371929'),(5,3,2,0,'chat','good messaged you.',0,'1460372675'),(6,3,2,0,'chat','good messaged you.',0,'1460372687'),(7,1,3,1,'like','good messaged you.',1,'1460372853'),(8,2,3,8,'chat','123456789',1,'1460381835'),(9,1,3,0,'chat','boris messaged you.',0,'1461976445'),(10,1,3,0,'chat','boris messaged you.',0,'1461978329'),(11,1,3,0,'chat','boris messaged you.',0,'1461978350'),(12,1,3,0,'chat','boris messaged you.',0,'1461995352'),(13,1,3,0,'chat','boris messaged you.',0,'1461995491'),(14,1,3,0,'chat','boris messaged you.',0,'1462015438'),(15,1,3,0,'chat','boris messaged you.',0,'1462015451'),(16,1,3,0,'chat','boris messaged you.',0,'1462821403'),(17,1,2,0,'chat','boris messaged you.',0,'1463045043'),(18,1,3,0,'chat','boris messaged you.',0,'1463045075'),(19,1,4,0,'chat','boris messaged you.',0,'1463045112'),(20,1,2,0,'follow','boris followed you.',0,'1463046694'),(21,1,5,0,'follow','boris followed you.',0,'1463046698'),(22,1,4,0,'chat','boris messaged you.',0,'1463046801');

/*Table structure for table `streams` */

DROP TABLE IF EXISTS `streams`;

CREATE TABLE `streams` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) NOT NULL,
  `account_id` int(10) NOT NULL,
  `userName` varchar(50) COLLATE utf8_bin NOT NULL,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `reported` int(1) NOT NULL DEFAULT '0',
  `blocked` int(1) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL DEFAULT '1',
  `created` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `streams` */

insert  into `streams`(`id`,`cat_id`,`account_id`,`userName`,`title`,`description`,`reported`,`blocked`,`state`,`created`) values (1,1,3,'boris','funny video stream','funny video on chicago stadium',0,0,1,'1445723658'),(2,1,1,'sergei','lyrical music','celebraitign concert',1,0,1,'1445724658');

/*Table structure for table `venues` */

DROP TABLE IF EXISTS `venues`;

CREATE TABLE `venues` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `venueName` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `state` varchar(100) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `lot` decimal(50,20) NOT NULL,
  `lat` decimal(50,20) NOT NULL,
  `created` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `venues` */

insert  into `venues`(`id`,`venueName`,`address`,`logo`,`state`,`active`,`lot`,`lat`,`created`) values (1,'chicago stadium','5000 Estate Enighed, Independence, KS 67301, USA','venue.jpg','',1,-95.71289100000001000000,37.09024000000000000000,'1460104934'),(3,'test 123','26-36 W 84th St, New York, NY 10024, USA','DM8zCOqj.jpg','',1,-73.97172086878669000000,40.78452255857115500000,'1461897017');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

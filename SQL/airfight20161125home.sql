/*
SQLyog Ultimate v11.42 (64 bit)
MySQL - 5.7.14 : Database - airfight
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`airfight` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `airfight`;

/*Table structure for table `battle_log` */

DROP TABLE IF EXISTS `battle_log`;

CREATE TABLE `battle_log` (
  `room_id` int(11) NOT NULL,
  `round` int(11) NOT NULL COMMENT '回合进度',
  `host_done` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'HOST是否行动',
  `challenger_done` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'CHALLENGER是否行动',
  `host_x` tinyint(4) DEFAULT NULL,
  `host_y` tinyint(4) DEFAULT NULL,
  `challenger_x` tinyint(4) DEFAULT NULL,
  `challenger_y` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `battle_room` */

DROP TABLE IF EXISTS `battle_room`;

CREATE TABLE `battle_room` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `host_id` int(64) DEFAULT '0',
  `challenger_id` int(64) DEFAULT '0',
  `kill_host` int(11) DEFAULT NULL,
  `kill_challenger` int(11) DEFAULT NULL,
  `plane_num` int(11) DEFAULT '3',
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1046 DEFAULT CHARSET=utf8;

/*Table structure for table `plane_location` */

DROP TABLE IF EXISTS `plane_location`;

CREATE TABLE `plane_location` (
  `room_id` int(11) NOT NULL,
  `player` int(11) NOT NULL COMMENT '玩家：1：HOST；2：CHALLENGER',
  `cor_x` tinyint(4) NOT NULL,
  `cor_y` tinyint(4) NOT NULL,
  `loc_type` tinyint(4) NOT NULL COMMENT '坐标类型：1：机身；5：机头',
  PRIMARY KEY (`room_id`,`player`,`cor_x`,`cor_y`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `user_info` */

DROP TABLE IF EXISTS `user_info`;

CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user_id`,`user_name`),
  UNIQUE KEY `unique` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

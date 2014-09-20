/*
Navicat MySQL Data Transfer

Source Server         : Xamp2
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : vote

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-09-20 23:55:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `avatar` varchar(50) DEFAULT 'avatar-default.jpg',
  `unit_id` int(11) NOT NULL,
  `teaching` text NOT NULL,
  `introduced` text NOT NULL,
  `status` int(5) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `fk_unit_id1` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for guide
-- ----------------------------
DROP TABLE IF EXISTS `guide`;
CREATE TABLE `guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for unit
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` text NOT NULL,
  `unit_des` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for vote
-- ----------------------------
DROP TABLE IF EXISTS `vote`;
CREATE TABLE `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `account_vote` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id1` (`account_id`),
  CONSTRAINT `fk_user_vote` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for vote_time
-- ----------------------------
DROP TABLE IF EXISTS `vote_time`;
CREATE TABLE `vote_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestart` datetime NOT NULL,
  `timeend` datetime NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- View structure for account_info
-- ----------------------------
DROP VIEW IF EXISTS `account_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `account_info` AS SELECT account.*, unit.unit_name, unit.unit_des FROM account JOIN unit WHERE account.unit_id = unit.id ;

-- ----------------------------
-- View structure for vote_info
-- ----------------------------
DROP VIEW IF EXISTS `vote_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `vote_info` AS SELECT vote.*, account_info.fullname as account_id_voted, account_info.unit_id, account_info.unit_name, account_info.avatar, account_info.`status` FROM `vote` JOIN account_info WHERE vote.account_id = account_info.id ;

/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50511
Source Host           : localhost:3306
Source Database       : polls

Target Server Type    : MYSQL
Target Server Version : 50511
File Encoding         : 65001

Date: 2013-04-04 17:13:13
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `polls`
-- ----------------------------
DROP TABLE IF EXISTS `polls`;
CREATE TABLE `polls` (
  `id` varchar(36) NOT NULL,
  `question` varchar(255) NOT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of polls
-- ----------------------------
INSERT INTO `polls` VALUES ('515cfd02-1560-4dc8-85ab-100ccbdd56cb', 'jQuery is a...', 'Demo Poll', '2013-04-04 06:09:38', '2013-04-04 06:09:55', '0');
INSERT INTO `polls` VALUES ('515d39e8-3180-4235-9cae-100ccbdd56cb', 'PHP MVC Framework?', '', '2013-04-04 10:29:28', '2013-04-04 10:29:28', '0');

-- ----------------------------
-- Table structure for `poll_options`
-- ----------------------------
DROP TABLE IF EXISTS `poll_options`;
CREATE TABLE `poll_options` (
  `id` varchar(36) NOT NULL,
  `poll_id` varchar(36) NOT NULL,
  `option` varchar(100) NOT NULL,
  `vote_count` int(11) NOT NULL DEFAULT '0',
  `ordered` smallint(6) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of poll_options
-- ----------------------------
INSERT INTO `poll_options` VALUES ('515cfd13-4d4c-4c88-bc0a-100ccbdd56cb', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', 'Ruby Gem', '2', '3', '2013-04-04 06:09:55');
INSERT INTO `poll_options` VALUES ('515cfd13-8e2c-4065-b71a-100ccbdd56cb', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', 'JavaScript library', '4', '1', '2013-04-04 06:09:55');
INSERT INTO `poll_options` VALUES ('515cfd13-a69c-41d9-8ec7-100ccbdd56cb', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', 'PHP Framework', '2', '4', '2013-04-04 06:09:55');
INSERT INTO `poll_options` VALUES ('515cfd13-f2d0-4b32-9be5-100ccbdd56cb', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', 'JavaScript framework', '3', '2', '2013-04-04 06:09:55');
INSERT INTO `poll_options` VALUES ('515d39e8-a2a4-4437-bdd8-100ccbdd56cb', '515d39e8-3180-4235-9cae-100ccbdd56cb', 'CakePHP', '2', '1', '2013-04-04 10:29:28');
INSERT INTO `poll_options` VALUES ('515d39e8-a7d4-4780-bfda-100ccbdd56cb', '515d39e8-3180-4235-9cae-100ccbdd56cb', 'Pear', '0', '3', '2013-04-04 10:29:28');
INSERT INTO `poll_options` VALUES ('515d39e8-c79c-43fb-83f4-100ccbdd56cb', '515d39e8-3180-4235-9cae-100ccbdd56cb', 'Smarty Template', '1', '2', '2013-04-04 10:29:28');

-- ----------------------------
-- Table structure for `poll_votes`
-- ----------------------------
DROP TABLE IF EXISTS `poll_votes`;
CREATE TABLE `poll_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` varchar(36) NOT NULL,
  `poll_option_id` varchar(36) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`),
  KEY `poll_option_id` (`poll_option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of poll_votes
-- ----------------------------
INSERT INTO `poll_votes` VALUES ('1', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', '515cfd13-f2d0-4b32-9be5-100ccbdd56cb', '2013-04-04 06:59:51');
INSERT INTO `poll_votes` VALUES ('2', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', '515cfd13-f2d0-4b32-9be5-100ccbdd56cb', '2013-04-04 07:01:32');
INSERT INTO `poll_votes` VALUES ('3', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', '515cfd13-a69c-41d9-8ec7-100ccbdd56cb', '2013-04-04 07:03:42');
INSERT INTO `poll_votes` VALUES ('4', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', '515cfd13-4d4c-4c88-bc0a-100ccbdd56cb', '2013-04-04 07:04:01');
INSERT INTO `poll_votes` VALUES ('5', '515d39e8-3180-4235-9cae-100ccbdd56cb', '515d39e8-a2a4-4437-bdd8-100ccbdd56cb', '2013-04-04 11:09:37');
INSERT INTO `poll_votes` VALUES ('6', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', '515cfd13-4d4c-4c88-bc0a-100ccbdd56cb', '2013-04-04 11:11:55');
INSERT INTO `poll_votes` VALUES ('7', '515d39e8-3180-4235-9cae-100ccbdd56cb', '515d39e8-c79c-43fb-83f4-100ccbdd56cb', '2013-04-04 11:13:02');
INSERT INTO `poll_votes` VALUES ('8', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', '515cfd13-f2d0-4b32-9be5-100ccbdd56cb', '2013-04-04 11:14:17');
INSERT INTO `poll_votes` VALUES ('9', '515d39e8-3180-4235-9cae-100ccbdd56cb', '515d39e8-a2a4-4437-bdd8-100ccbdd56cb', '2013-04-04 11:17:47');
INSERT INTO `poll_votes` VALUES ('10', '515cfd02-1560-4dc8-85ab-100ccbdd56cb', '515cfd13-a69c-41d9-8ec7-100ccbdd56cb', '2013-04-04 11:18:04');
INSERT INTO `poll_votes` VALUES ('11', '515d475c-0000-4dc2-ab70-1410cbdd56cb', '515d475c-de60-47e7-a7fc-1410cbdd56cb', '2013-04-04 11:26:56');

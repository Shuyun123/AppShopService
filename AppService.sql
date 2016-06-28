/*
 Navicat Premium Data Transfer

 Source Server         : anumbrella
 Source Server Type    : MySQL
 Source Server Version : 50546
 Source Host           : www.anumbrella.net
 Source Database       : AppService

 Target Server Type    : MySQL
 Target Server Version : 50546
 File Encoding         : utf-8

 Date: 06/28/2016 10:02:26 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `logintime` int(11) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `admin`
-- ----------------------------
BEGIN;
INSERT INTO `admin` VALUES ('1', 'admin', '1467079212', '202cb962ac59075b964b07152d234b70');
COMMIT;

-- ----------------------------
--  Table structure for `banner`
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `introduce` text NOT NULL,
  `number` int(11) NOT NULL,
  `img` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `banner`
-- ----------------------------
BEGIN;
INSERT INTO `banner` VALUES ('3', 'iphone6', ' 9成新品', '1', '/Uploads/img/5751108b3b311.jpg'), ('4', 'iphone6s', '良心品质', '2', '/Uploads/img/575110eecefb8.jpg'), ('5', 'iphone5s', '洛克良品', '3', '/Uploads/img/5751111220359.jpg'), ('6', 'iphone5c', '品质保障', '4', '/Uploads/img/575111334ab78.jpg');
COMMIT;

-- ----------------------------
--  Table structure for `buy`
-- ----------------------------
DROP TABLE IF EXISTS `buy`;
CREATE TABLE `buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `sum` int(11) NOT NULL,
  `total` float(11,2) NOT NULL,
  `ispay` int(11) NOT NULL DEFAULT '0',
  `isdeliver` int(11) NOT NULL DEFAULT '0',
  `iscomment` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `buy`
-- ----------------------------
BEGIN;
INSERT INTO `buy` VALUES ('156', '11', '30', '1', '69.00', '1', '1', '1'), ('159', '7', '30', '1', '2999.00', '1', '1', '1'), ('163', '6', '31', '1', '3999.00', '0', '0', '0'), ('164', '13', '31', '1', '69.00', '0', '0', '0'), ('165', '6', '33', '1', '3999.00', '0', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `comment`
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `commentcontent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `describe` int(11) NOT NULL,
  `deliver` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `commenttime` int(11) NOT NULL,
  `like` int(11) NOT NULL DEFAULT '0',
  `subcount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `comment`
-- ----------------------------
BEGIN;
INSERT INTO `comment` VALUES ('36', '30', '11', '156', '%F0%9F%98%81%F0%9F%98%82%F0%9F%98%83%F0%9F%98%84%E9%98%BF%E5%BE%B7', '5', '5', '5', '1466315331', '6', '0'), ('37', '30', '7', '159', '%F0%9F%98%81%F0%9F%98%81%F0%9F%98%81', '5', '5', '5', '1466318371', '3', '0'), ('38', '31', '11', '162', '123%F0%9F%98%81%F0%9F%98%82%F0%9F%98%93', '4', '5', '4', '1466517519', '3', '0');
COMMIT;

-- ----------------------------
--  Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `price` float(11,2) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `img` text NOT NULL,
  `carrieroperator` int(11) NOT NULL,
  `color` text NOT NULL,
  `storage` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `product`
-- ----------------------------
BEGIN;
INSERT INTO `product` VALUES ('6', 'iPhone 6s', '3999.00', '0', '/Uploads/img/5751585bb372f.jpg', '0', '0', '0'), ('7', 'iPhone 6', '2999.00', '0', '/Uploads/img/5751587c823b7.jpg', '0', '0', '0'), ('8', 'iPhone 6s', '38000.00', '1', '/Uploads/img/57515a466b122.jpg', '0', '0', '0'), ('9', 'iPhone 6s', '4200.00', '0', '/Uploads/img/57515a778b17f.jpg', '0', '1', '1'), ('10', 'iPhone 5s', '2999.00', '0', '/Uploads/img/57515abeb4808.jpg', '0', '0', '0'), ('11', 'Apple正品充电头', '69.00', '2', '/Uploads/img/57517d9d03cbd.jpg', '-1', '-1', '-1'), ('12', 'Apple正品耳机earpods', '99.00', '2', '/Uploads/img/5751805760bfd.jpg', '-1', '-1', '-1'), ('13', 'Apple正品充电线数据线', '69.00', '2', '/Uploads/img/5751809a76b71.jpg', '-1', '-1', '-1'), ('14', '糖果色硅胶壳', '10.00', '3', '/Uploads/img/575181159f4bb.jpg', '-1', '-1', '-1'), ('15', '免费贴高清膜一张', '0.01', '3', '/Uploads/img/575181390c443.jpg', '-1', '-1', '-1');
COMMIT;

-- ----------------------------
--  Table structure for `subcomment`
-- ----------------------------
DROP TABLE IF EXISTS `subcomment`;
CREATE TABLE `subcomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentcontent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commenttime` int(11) NOT NULL,
  `like` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `subcomment`
-- ----------------------------
BEGIN;
INSERT INTO `subcomment` VALUES ('58', '%E6%B5%8B%E8%AF%95%F0%9F%98%81%F0%9F%98%82%F0%9F%98%83', '1466315968', '4', '36', '30'), ('59', '%F0%9F%98%82%F0%9F%98%82%F0%9F%98%82', '1466316365', '6', '36', '30'), ('60', '%F0%9F%95%89%F0%9F%95%89%F0%9F%95%89%F0%9F%95%89%F0%9F%95%89', '1466316471', '16', '36', '30'), ('61', '%F0%9F%98%83%F0%9F%98%84%F0%9F%91%BF%F0%9F%91%BF', '1466316524', '12', '36', '30'), ('62', '%F0%9F%91%BF%F0%9F%91%BF%F0%9F%91%BF%F0%9F%91%BF', '1466316655', '4', '36', '30'), ('63', '%F0%9F%98%81%F0%9F%98%81%F0%9F%98%81', '1466316740', '2', '36', '30'), ('64', '%40', '1466317167', '2', '36', '30'), ('65', '%F0%9F%98%81%F0%9F%98%82', '1466318300', '1', '36', '30'), ('66', 'fff', '1466318415', '2', '37', '30'), ('67', '%F0%9F%98%82', '1466324454', '1', '37', '30'), ('68', '%E2%9A%BE%E2%9A%BE%E2%9A%BE', '1466338395', '1', '36', '30'), ('69', '%F0%9F%95%89%F0%9F%95%89', '1466343921', '2', '37', '30'), ('70', '%E2%98%82%E2%98%82', '1466383792', '1', '36', '30'), ('71', '%E2%9A%BE', '1466485550', '3', '36', '30'), ('72', '%F0%9F%98%82', '1466486973', '2', '36', '30'), ('73', '%F0%9F%89%90', '1466487272', '1', '36', '30'), ('74', '%F0%9F%98%82%F0%9F%98%82%F0%9F%91%BF', '1466487322', '0', '36', '30'), ('75', '%F0%9F%98%82', '1466487337', '0', '36', '30'), ('76', '%E6%B5%8B%E8%AF%95', '1466487381', '0', '36', '30'), ('77', '%F0%9F%98%82', '1466507378', '1', '36', '30'), ('78', '111', '1466509564', '1', '36', '30'), ('79', '%F0%9F%98%81', '1466510060', '2', '36', '30'), ('80', '%F0%9F%A4%97%E2%9A%BD', '1466511452', '10', '36', '31'), ('81', '%E2%9A%BD', '1466517543', '1', '38', '31'), ('82', '%F0%9F%98%82', '1466517586', '3', '38', '31'), ('83', '%F0%9F%A4%97', '1466568755', '1', '38', '31'), ('84', '%F0%9F%99%83%F0%9F%99%83%F0%9F%98%9A%F0%9F%98%9C%F0%9F%98%9C%F0%9F%98%9C%F0%9F%98%9C', '1466568762', '1', '38', '31'), ('85', '%F0%9F%98%9C%F0%9F%98%9A', '1466576675', '1', '38', '32'), ('86', '%F0%9F%98%81', '1466589955', '1', '38', '31'), ('87', '%E2%9A%BD', '1466610046', '1', '36', '31'), ('88', '%F0%9F%98%9C', '1466675809', '1', '36', '31'), ('89', '%F0%9F%A4%97', '1466727972', '1', '36', '31'), ('90', '%E2%9A%BD', '1466747939', '0', '37', '31'), ('91', '%F0%9F%99%83', '1466873232', '0', '36', '31');
COMMIT;

-- ----------------------------
--  Table structure for `updateapp`
-- ----------------------------
DROP TABLE IF EXISTS `updateapp`;
CREATE TABLE `updateapp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appname` text NOT NULL,
  `versioncode` int(11) NOT NULL,
  `apppath` text NOT NULL,
  `updatetime` int(11) NOT NULL,
  `updatecontent` text NOT NULL,
  `versionname` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `updateapp`
-- ----------------------------
BEGIN;
INSERT INTO `updateapp` VALUES ('1', '洛克商城', '1', '洛克商城.apk', '1466783519', '暂无更新', '1.0');
COMMIT;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `logintime` int(11) NOT NULL,
  `iconimg` text,
  `signname` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('35', '18166387244', '打伞的她', '202cb962ac59075b964b07152d234b70', '1466947873', '/Uploads/icon/1467009171782.jpg', 'Android');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;

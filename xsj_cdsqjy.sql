/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : xsj_cdsqjy

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2019-11-29 17:02:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yf_article`
-- ----------------------------
DROP TABLE IF EXISTS `yf_article`;
CREATE TABLE `yf_article` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `faceimg` varchar(255) DEFAULT NULL,
  `col` int(11) DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  `postdate` date DEFAULT NULL,
  `style` int(11) DEFAULT NULL,
  `editor` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yf_article
-- ----------------------------
INSERT INTO `yf_article` VALUES ('20', '没见过世面的爸妈', '20191127/0076fb55a5dbfcf30093eae799ce6a24.jpg', '1', 'https://mp.weixin.qq.com/s/4LcHtAM3K_lWS07oX5yCiA', '2019-10-27', '4', '1', '2');
INSERT INTO `yf_article` VALUES ('7', '【主题教育进行时】强警示，守初心', '20191127/0669c4dba6a58a75d4f9a9134f002c92.jpg', '1', 'https://mp.weixin.qq.com/s/1pT0ZuOaPCz6yg0LMe1rRA', '2019-10-29', '1', '1', '2');
INSERT INTO `yf_article` VALUES ('18', '2020年放假安排，来了！', '20191127/542856c9a64773330a6136e1c63435b8.jpg', '1', 'https://mp.weixin.qq.com/s/rN4VaC7OWe2o8GYlXhx8jg', '2019-10-08', '1', '1', '2');
INSERT INTO `yf_article` VALUES ('21', '四川省人大常委会任免几名干部', '20191129/b81f6138a3971b74c49137f6fb8b1c33.jpg', '1', 'https://mp.weixin.qq.com/s/5M-fAwQZsQK0ObGrhf8mdA', '2019-10-29', '1', '1', '2');
INSERT INTO `yf_article` VALUES ('22', '达州这个村支书上了《人民日报》', '20191129/f8e863c4f6b7617fbdf9045309c5afb2.jpg', '2', 'https://mp.weixin.qq.com/s/KloxHijhU3QOH1iq6rkk2w', '2019-10-29', '1', '1', '2');
INSERT INTO `yf_article` VALUES ('23', '达州这个村支书上了《人民日报》', '20191129/1170a20254e7741f07f6af2813b424f5.jpg', '3', 'https://mp.weixin.qq.com/s/KloxHijhU3QOH1iq6rkk2w', '2019-10-29', '1', '1', '2');
INSERT INTO `yf_article` VALUES ('24', '达州这个村支书上了《人民日报》', '20191129/a54c53e2551a69b913310edef0a13abb.jpg', '1', 'https://mp.weixin.qq.com/s/KloxHijhU3QOH1iq6rkk2w', '2019-10-29', '1', '1', '2');
INSERT INTO `yf_article` VALUES ('25', '达州这个村支书上了《人民日报》', '20191129/c928dd4bb61b6e0eee8c0ff78d004bd8.jpg', '1', 'https://mp.weixin.qq.com/s/KloxHijhU3QOH1iq6rkk2w', '2019-10-29', '1', '1', '2');
INSERT INTO `yf_article` VALUES ('26', '达州这个村支书上了《人民日报》', '20191129/5958e9d525df3bb23ef1411dfe38cfcc.jpg', '1', 'https://mp.weixin.qq.com/s/KloxHijhU3QOH1iq6rkk2w', '2019-10-29', '1', '1', '2');

-- ----------------------------
-- Table structure for `yf_col`
-- ----------------------------
DROP TABLE IF EXISTS `yf_col`;
CREATE TABLE `yf_col` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `col` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `top` bit(1) DEFAULT NULL,
  `search` bit(1) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yf_col
-- ----------------------------
INSERT INTO `yf_col` VALUES ('1', '新闻', 'insert_chart_outlined', '', '');
INSERT INTO `yf_col` VALUES ('2', '动态', 'chat', '', '');
INSERT INTO `yf_col` VALUES ('3', '调研', 'map', '', '');

-- ----------------------------
-- Table structure for `yf_status`
-- ----------------------------
DROP TABLE IF EXISTS `yf_status`;
CREATE TABLE `yf_status` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yf_status
-- ----------------------------
INSERT INTO `yf_status` VALUES ('1', '未发布');
INSERT INTO `yf_status` VALUES ('2', '已发布');

-- ----------------------------
-- Table structure for `yf_user`
-- ----------------------------
DROP TABLE IF EXISTS `yf_user`;
CREATE TABLE `yf_user` (
  `uid` int(11) NOT NULL,
  `user` varchar(60) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `nickname` varchar(40) DEFAULT NULL,
  `headimg` varchar(255) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `lastlogintime` int(11) DEFAULT NULL,
  `lastloginip` varchar(15) DEFAULT NULL,
  `identity` varchar(255) DEFAULT NULL,
  `errnum` int(2) DEFAULT NULL,
  `valid` bit(1) DEFAULT NULL,
  `forbidtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yf_user
-- ----------------------------
INSERT INTO `yf_user` VALUES ('1', 'admin', 'UuRVv07oWopqxfg7S49O+Q==', '刘尧夫', 'headimg/1.gif', '1570519905', '1570519905', '192.108.0.0', '1,2,3', '0', '', null);
INSERT INTO `yf_user` VALUES ('2', 'yfso', 'UuRVv07oWopqxfg7S49O+Q==', '刘小二', 'headimg/2.gif', '1570519905', '1570519905', '192.108.0.0', '1,2', '0', '', null);

/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : wp

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2013-10-02 19:03:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wp_cat_tipo_diabetes`
-- ----------------------------
DROP TABLE IF EXISTS `wp_cat_tipo_diabetes`;
CREATE TABLE `wp_cat_tipo_diabetes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wp_cat_tipo_diabetes
-- ----------------------------
INSERT INTO `wp_cat_tipo_diabetes` VALUES ('1', 'Ninguna');
INSERT INTO `wp_cat_tipo_diabetes` VALUES ('2', 'Tipo 1');
INSERT INTO `wp_cat_tipo_diabetes` VALUES ('3', 'Tipo 3');
INSERT INTO `wp_cat_tipo_diabetes` VALUES ('4', 'Gestacional');

-- ----------------------------
-- Table structure for `wp_cat_tipo_sangre`
-- ----------------------------
DROP TABLE IF EXISTS `wp_cat_tipo_sangre`;
CREATE TABLE `wp_cat_tipo_sangre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wp_cat_tipo_sangre
-- ----------------------------
INSERT INTO `wp_cat_tipo_sangre` VALUES ('1', 'O-');
INSERT INTO `wp_cat_tipo_sangre` VALUES ('2', 'O+');
INSERT INTO `wp_cat_tipo_sangre` VALUES ('3', 'A-');
INSERT INTO `wp_cat_tipo_sangre` VALUES ('4', 'A+');
INSERT INTO `wp_cat_tipo_sangre` VALUES ('5', 'B-');
INSERT INTO `wp_cat_tipo_sangre` VALUES ('6', 'B+');
INSERT INTO `wp_cat_tipo_sangre` VALUES ('7', 'AB-');
INSERT INTO `wp_cat_tipo_sangre` VALUES ('8', 'AB+');

/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : wp

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2013-10-02 17:44:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wp_datos_basicos`
-- ----------------------------
DROP TABLE IF EXISTS `wp_datos_basicos`;
CREATE TABLE `wp_datos_basicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wp_users_id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `ap_paterno` varchar(55) DEFAULT NULL,
  `ap_materno` varchar(55) DEFAULT NULL,
  `encargado_emergencia` varchar(70) DEFAULT NULL,
  `tel_emergencia` varchar(45) DEFAULT NULL,
  `correo_emergencia` varchar(70) DEFAULT NULL,
  `nom_medico` varchar(70) DEFAULT NULL,
  `tel_medico` varchar(45) DEFAULT NULL,
  `numero_celular` varchar(45) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `peso` decimal(2,0) DEFAULT NULL,
  `estatura` decimal(4,2) DEFAULT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wp_datos_basicos_wp_users1_idx` (`wp_users_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ----------------------------
-- Records of wp_datos_basicos
-- ----------------------------

-- ----------------------------
-- Table structure for `wp_datos_medicos`
-- ----------------------------
DROP TABLE IF EXISTS `wp_datos_medicos`;
CREATE TABLE `wp_datos_medicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wp_users_id` int(11) NOT NULL,
  `wp_cat_tipo_sangre_id` int(11) NOT NULL,
  `wp_cat_tipo_diabetes_id` int(11) NOT NULL,
  `presion_arterial_diastolica` int(11) DEFAULT NULL,
  `presion_arterial_sistolica` int(11) DEFAULT NULL,
  `donador_organos` tinyint(1) DEFAULT NULL,
  `alergias` text,
  `medicamentos` text,
  `enfermedades` text,
  `cirugias` text,
  `otras_consideraciones` text,
  `d_auditiva` text,
  `d_mental` text,
  `d_motora` text,
  `d_visual` text,
  `marcapasos` text,
  `lentes_contacto` text,
  `p_dentales` text,
  `p_oculares` text,
  `med_natural` text,
  PRIMARY KEY (`id`),
  KEY `fk_wp_dat_med_wp_users1_idx` (`wp_users_id`),
  KEY `fk_wp_dat_med_wp_cat_tipo_san_idx` (`wp_cat_tipo_sangre_id`),
  KEY `fk_wp_datos_medicos_wp_cat_tipo_diab_idx` (`wp_cat_tipo_diabetes_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wp_datos_medicos
-- ----------------------------

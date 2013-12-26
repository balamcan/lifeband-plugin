<?php

/*
  Plugin Name: Life Band Plugin
  Description: A brief description of the Plugin.
  Version: 1.0
  Author: Balam Palma
  License: GPL2
 */

//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//SETUP
global $jal_db_version;
$jal_db_version = "1.0";

function lifeband_plugin_update() {
    //Do some installation work
    global $wpdb;
    $template_directory=get_template_directory();
    $plugin_directory=plugins_url().'/lifeband-plugin/';
    $copy_files=array();
    $f_functions=null;
    //the others tables

    $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_pass_qr` (`id` int(11) NOT NULL AUTO_INCREMENT, `pass` varchar(10) NOT NULL, `id_user` bigint(20) DEFAULT NULL, PRIMARY KEY (`id`) ) DEFAULT CHARSET=utf8;");
    $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_datos_medicos` (`id` int(11) NOT NULL AUTO_INCREMENT, `wp_users_id` int(11) NOT NULL, `wp_cat_tipo_sangre_id` int(11) DEFAULT NULL, `wp_cat_tipo_diabetes_id` int(11) NOT NULL, `presion_arterial_diastolica` int(11) DEFAULT NULL, `presion_arterial_sistolica` int(11) DEFAULT NULL, `donador_organos` tinyint(1) DEFAULT NULL, `alergias` text, `medicamentos` text, `enfermedades` text, `cirugias` text, `otras_consideraciones` text, `d_auditiva` text, `d_mental` text, `d_motora` text, `d_visual` text, `marcapasos` text, `lentes_contacto` text, `p_dentales` text, `p_oculares` text, `med_natural` text, PRIMARY KEY (`id`), KEY `fk_wp_dat_med_wp_users1_idx` (`wp_users_id`), KEY `fk_wp_dat_med_wp_cat_tipo_san_idx` (`wp_cat_tipo_sangre_id`), KEY `fk_wp_datos_medicos_wp_cat_tipo_diab_idx` (`wp_cat_tipo_diabetes_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");
    $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_datos_basicos` (`id` int(11) NOT NULL AUTO_INCREMENT, `wp_users_id` int(11) NOT NULL, `nombre` varchar(120) NOT NULL, `ap_paterno` varchar(55) DEFAULT NULL, `ap_materno` varchar(55) DEFAULT NULL, `encargado_emergencia` varchar(70) DEFAULT NULL, `tel_emergencia` varchar(45) DEFAULT NULL, `correo_emergencia` varchar(70) DEFAULT NULL, `nom_medico` varchar(70) DEFAULT NULL, `tel_medico` varchar(45) DEFAULT NULL, `fecha_nac` date DEFAULT NULL, `peso` decimal(2,0) DEFAULT NULL, `estatura` decimal(4,2) DEFAULT NULL, `sexo` varchar(1) DEFAULT NULL, PRIMARY KEY (`id`), KEY `fk_wp_datos_basicos_wp_users1_idx` (`wp_users_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

}
?>

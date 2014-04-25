<?php
/*
  Plugin Name: Life Band Plugin
  Description: Custom plugin for administrate custom tables and page QR support.
  Version: 2.0
  Author: Balam Palma
  License: GPL2
 */

//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//SETUP
global $jal_db_version;
$jal_db_version = "1.0";

function lifeband_plugin_install() {
    //Do some installation work
    global $wpdb;
    $template_directory=get_template_directory();
    $plugin_directory=plugins_url().'/lifeband-plugin/';
    $copy_files=array();
    $f_functions=null;
    /* creating calatogos */
    
    //$wpdb->query("DROP TABLE IF EXISTS `wp_cat_tipo_diabetes`;");
    $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_cat_tipo_diabetes` (`id` int(11) NOT NULL AUTO_INCREMENT, `nombre` varchar(20) NOT NULL, PRIMARY KEY (`id`))DEFAULT CHARSET=utf8 ;");
    //$wpdb->query("INSERT INTO `wp_cat_tipo_diabetes` (`id`, `nombre`) VALUES (1, 'Ninguna'), (2, 'Tipo 1'), (3, 'Tipo 3'), (4, 'Gestacional');");
    //$wpdb->query("DROP TABLE IF EXISTS `wp_cat_tipo_sangre`;");
    $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_cat_tipo_sangre` (`id` int(11) NOT NULL AUTO_INCREMENT, `nombre` varchar(3) NOT NULL, PRIMARY KEY (`id`) )  DEFAULT CHARSET=utf8 ;");
    //$wpdb->query("INSERT INTO `wp_cat_tipo_sangre` (`id`, `nombre`) VALUES (1, 'O-'), (2, 'O+'), (3, 'A-'), (4, 'A+'), (5, 'B-'), (6, 'B+'), (7, 'AB-'), (8, 'AB+');");
    //the others tables
    $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_pass_qr` (`id` int(11) NOT NULL AUTO_INCREMENT, `pass` varchar(10) NOT NULL, `id_user` bigint(20) DEFAULT NULL, PRIMARY KEY (`id`) ) DEFAULT CHARSET=utf8;");
    $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_datos_medicos` (`id` int(11) NOT NULL AUTO_INCREMENT, `wp_users_id` int(11) NOT NULL, `wp_cat_tipo_sangre_id` int(11), `wp_cat_tipo_diabetes_id` int(11) NOT NULL, `presion_arterial_diastolica` int(11) DEFAULT NULL, `presion_arterial_sistolica` int(11) DEFAULT NULL, `donador_organos` tinyint(1) DEFAULT NULL, `alergias` text, `medicamentos` text, `enfermedades` text, `cirugias` text, `otras_consideraciones` text, `d_auditiva` text, `d_mental` text, `d_motora` text, `d_visual` text, `marcapasos` text, `lentes_contacto` text, `p_dentales` text, `p_oculares` text, `med_natural` text, PRIMARY KEY (`id`), KEY `fk_wp_dat_med_wp_users1_idx` (`wp_users_id`), KEY `fk_wp_dat_med_wp_cat_tipo_san_idx` (`wp_cat_tipo_sangre_id`), KEY `fk_wp_datos_medicos_wp_cat_tipo_diab_idx` (`wp_cat_tipo_diabetes_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");
    $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_datos_basicos` (`id` int(11) NOT NULL AUTO_INCREMENT, `wp_users_id` int(11) NOT NULL, `nombre` varchar(120) NOT NULL, `ap_paterno` varchar(55) DEFAULT NULL, `ap_materno` varchar(55) DEFAULT NULL, `encargado_emergencia` varchar(70) DEFAULT NULL, `tel_emergencia` varchar(45) DEFAULT NULL, `correo_emergencia` varchar(70) DEFAULT NULL, `nom_medico` varchar(70) DEFAULT NULL, `tel_medico` varchar(45) DEFAULT NULL, `fecha_nac` date DEFAULT NULL, `peso` decimal(2,0) DEFAULT NULL, `estatura` decimal(4,2) DEFAULT NULL, `sexo` varchar(1) DEFAULT NULL, PRIMARY KEY (`id`), KEY `fk_wp_datos_basicos_wp_users1_idx` (`wp_users_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

    
}

register_activation_hook(__FILE__, 'lifeband_plugin_install');

register_activation_hook(__FILE__, 'jal_install_data');

//SCRIPTS
function lifeband_plugin_scripts() {
    wp_register_script('lifeband_plugin_script', plugin_dir_url(__FILE__) . 'js/lifeband-plugin.js');
    wp_enqueue_script('lifeband_plugin_script');
}

add_action('wp_enqueue_scripts', 'lifeband_plugin_scripts');
/* f you want to run your program every time a visitor comes
 *  to your site, you can use the ‘init’ or ‘wp_loaded’ action
 *  to trigger your code: */

//HOOKS
add_action('init', 'lifeband_plugin_init');
/* * ***************************************************** */
/* FUNCTIONS
 * ****************************************************** */

function lifeband_plugin_init() {
    //do work
    run_sub_process();
    lifeband_plugin_install();
}

function run_sub_process() {
    //more work
}

/* INITIALIZE THE ADMIN FUNCTIONS */

//1
function lifeband_plugin_menu() {
    add_options_page('Life Band Plugin Options', 'Life Band Plugin', 'manage_options', 'lifeband-plugin-menu', 'lifeband_plugin_options');
}
function lifeband_event_plugin_menu() {
    add_options_page('Life Band Events Plugin Options', 'Life Band Event Plugin', 'manage_options', 'lifeband-plugin-menu', 'lifeband_plugin_event_options');
}


function register_mysettings() {
//register our settings
    register_setting('lifeband-settings-group', 'new_option_name');
    register_setting('lifeband-settings-group', 'some_other_option');
    register_setting('lifeband-settings-group', 'option_etc');
}

//2
add_action('admin_menu', 'lifeband_plugin_menu');
add_action('admin_menu', 'lifeband_plugin_event_menu');

//3
function lifeband_plugin_options() {
    include('admin/lifeband-plugin-admin.php');
    include('admin/usuarios-generados.php');
}
function lifeband_plugin_event_options() {
    include('admin/eventos-admin.php');
}
function life_band_users_factory(){
    include('admin/lifeband-generate-users.php');
}
?>

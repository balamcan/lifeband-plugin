<?php
/*
Plugin Name: Life Band plugin
Plugin URI: http://none.com
Description: A brief description of the Plugin.
Version: 0.1
Author: Balam Palma
Author URI: http://none.com
License: GPL2
*/

//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//SETUP
global $jal_db_version;
$jal_db_version = "1.0";
function lifeband_plugin_install(){
    //Do some installation work
    global $wpdb;
    global $jal_db_version;
    $table_name = $wpdb->prefix."pass_qr";
    $table_users = $wpdb->prefix."users";
    $sql = "CREATE TABLE IF NOT EXISTS $table_name(
        id int(11) NOT NULL,
        pass varchar(10) NOT NULL,
        PRIMARY KEY  (id),
        KEY id (id),
        CONSTRAINT `fk___pass___users1`
          FOREIGN KEY (id )
          REFERENCES $table_users (id)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION
      ); 
      ";
       require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
       dbDelta($sql);
       add_option( "jal_db_version", $jal_db_version );
       
    /*Create additional tables for the custom database*/
}
register_activation_hook(__FILE__,'lifeband_plugin_install'); 
//SCRIPTS
function lifeband_plugin_scripts(){
    wp_register_script('lifeband_plugin_script',plugin_dir_url( __FILE__ ).'js/lifeband-plugin.js');
    wp_enqueue_script('lifeband_plugin_script');
}
add_action('wp_enqueue_scripts','lifeband_plugin_scripts'); 
/*f you want to run your program every time a visitor comes
 *  to your site, you can use the ‘init’ or ‘wp_loaded’ action
 *  to trigger your code:*/

//HOOKS
add_action('init','lifeband_plugin_init');
/********************************************************/
/* FUNCTIONS
********************************************************/
function lifeband_plugin_init(){
    //do work
    run_sub_process();
    lifeband_plugin_install();
}

function run_sub_process(){
    //more work
}

/* INITIALIZE THE ADMIN FUNCTIONS */

//1
function lifeband_plugin_menu() {
    add_options_page('Life Band Plugin Options', 'Life Band Plugin', 'manage_options', 'lifeband-plugin-menu', 'lifeband_plugin_options');
}

function register_mysettings() {
//register our settings
    register_setting('lifeband-settings-group', 'new_option_name');
    register_setting('lifeband-settings-group', 'some_other_option');
    register_setting('lifeband-settings-group', 'option_etc');
}

//2
add_action('admin_menu', 'lifeband_plugin_menu');

//3
function lifeband_plugin_options() {
    include('admin/lifeband-plugin-admin.php');
}

?>

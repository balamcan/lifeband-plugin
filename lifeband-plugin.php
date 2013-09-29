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
//SETUP
function lifeband_plugin_install(){
    //Do some installation work
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
}

function run_sub_process(){
    //more work
}
include_once ('init-admin.php');
?>

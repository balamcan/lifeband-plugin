<?php

/*
 * Template Name: Qr
 */
global $avia_config;

function lifeband_plugin_update() {
    //Do some installation work
    global $wpdb;
//    $template_directory=get_template_directory();
//    $plugin_directory=plugins_url().'/lifeband-plugin/';
//    $copy_files=array();
//    $f_functions=null;
    //the others tables

    IF ($wpdb->query("DROP PROCEDURE IF EXISTS deleteUserById;
CREATE PROCEDURE `deleteUserById`(userID BIGINT) BEGIN Delete from wp_usermeta where wp_usermeta.user_id = userID;
Delete from wp_users where wp_users.ID = userID;
Delete from wp_pass_qr where id_user = userID;
END;") === FALSE) {
        wp_die(__('Crap! well that’s screwed up: ' . $wpdb->last_error));
    }
}

lifeband_plugin_update();
?>
<?php

function redirect_user_on_role() {
    global $wpdb;
    //retrieve current user info 
    global $current_user;
    get_currentuserinfo();
    //If login user role is Subscriber
    $human_user=get_user_meta($current_user->ID, 'wp_human_user');
    if ($current_user->user_level == 0) {
        if ( $human_user == '1') {// con esta condicional sabes si existe el user meta
            wp_redirect('http://'.$_SERVER['HTTP_HOST'].'/wp/confirmar-datos/');
            exit;
        } else {
            wp_redirect('http://'.$_SERVER['HTTP_HOST'].'/wp/datos-medicos/');exit;
        }
    }
    //If login user role is Contributor
//    else if ($current_user->user_level > 1) {
//        wp_redirect(home_url());
//        exit;
//    }
//    //If login user role is Editor
//    else if ($current_user->user_level > 8) {
//        wp_redirect(home_url());
//        exit;
//    }
    // For other rolse 
//    else {
//        $redirect_to = 'http://google.com/';
//        return $redirect_to;
//    }
}

add_action('admin_init', 'redirect_user_on_role');?>

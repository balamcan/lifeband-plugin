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
/*
Plugin Name: Allow Email Login
Plugin URI: http://en.bainternet.info
Description: Username Allow Email LogIn
Version: 1.0
Author: Bainternet
Author URI: http://en.bainternet.info
*/
 
add_filter('authenticate', 'bainternet_allow_email_login', 20, 3);
/**
 * bainternet_allow_email_login filter to the authenticate filter hook, to fetch a username based on entered email
 * @param  obj $user
 * @param  string $username [description]
 * @param  string $password [description]
 * @return boolean
 */
function bainternet_allow_email_login( $user, $username, $password ) {
    if ( is_email( $username ) ) {
        $user = get_user_by_email( $username );
        if ( $user ) $username = $user->user_login;
    }
    return wp_authenticate_username_password(null, $username, $password );
}
 
add_filter( 'gettext', 'addEmailToLogin', 20, 3 );
/**
 * addEmailToLogin function to add email address to the username label
 * @param string $translated_text   translated text
 * @param string $text              original text
 * @param string $domain            text domain
 */
function addEmailToLogin( $translated_text, $text, $domain ) {
    if ( "Username" == $translated_text )
        $translated_text .= __( ' Or Email');
    return $translated_text;
}
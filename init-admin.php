<?php

/* INITIALIZE THE ADMIN FUNCTIONS */

//1
function lifeband_plugin_menu() {
    add_options_page('Super Plugin Options', 'Super Plugin', 'manage_options', 'lifeband-plugin-menu', 'lifeband_plugin_options');
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

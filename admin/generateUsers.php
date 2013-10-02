<?php


require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
include_once(ABSPATH  . '/wp-config.php');
include_once(ABSPATH  . '/wp-load.php');
include_once(ABSPATH . '/wp-includes/wp-db.php');

class generateUsers {
        
    var $i = 0;
    var $nombreUsuario = '';
    var $pass = '';
    var $lastId = 0;
    var $passusr = '';
        
    function usersMetaInsert($id,$nombre){
        global $wpdb;
        $user_meta = array(user_id => $id,
            meta_key => 'first_name',
            meta_value => '');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'last_name',
            meta_value => '');
         $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'nickname',
            meta_value => $nombre);
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'description',
            meta_value => '');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'rich_editing',
            meta_value => 'true');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'comment_shorcuts',
            meta_value => 'false');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'admin_color',
            meta_value => 'fresh');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'use_ssl',
            meta_value => '0');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'show_admin_bar_front',
            meta_value => 'true');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'wp_capabilities',
            meta_value => 'a:1:{s:10:"subscriber";b:1;}');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'wp_user_level',
            meta_value => '0');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);
        $user_meta = array(user_id => $id,
            meta_key => 'dismissed_wp_pointers',
            meta_value => 'wp330_toolbar,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link,wp350_media,wp360_revisions,wp360_locks');
        $wpdb->insert($wpdb->prefix . 'usermeta', $user_meta);           
    }
            
    function canti($cant = 50) {
        
        global $wpdb;
        While ($this->i <= $cant) {
            $this->lastId = $wpdb->get_var("SELECT id from " . $wpdb->prefix . "users order by id desc limit 1",0,0);
            $this->lastId = $this->lastId + 1;
            $this->passusr = wp_generate_password(8);
            $this->pass = wp_hash_password($this->passusr);
            $this->nombreUsuario = substr(sha1(lastId), 1, 4) . strrev(lastId);
            $this->correo = $this->nombreUsuario . '@lifeband.com';
            var_dump($this->lastId);
            echo "<- lastId <br>";
            var_dump($wpdb->last_error);
            echo "<- select error <br>";
            $usersTb = array(
                'user_nicename' => $this->nombreUsuario,
                'user_email' => $this->correo,
                'user_pass' => $this->pass,
                'user_registered' => gmdate('Y-m-d H:i:s'),
                'user_status' => 0
            );
            var_dump($usersTb);
            echo "<- users Tb <br>";
            $userPassTb = array('pass' => $this->passusr,'id_user' => $this->lastId,);
            var_dump($userPassTb);
            echo "<- user Pass Tb <br>";
            $wpdb->insert($wpdb->prefix . 'users', $usersTb);
            var_dump($wpdb->last_error);
            echo "<- Insert users Tb <br>";
            $this->usersMetaInsert($this->lastId, $nombreUsuario);
            echo "usersMetaInsert <br>";
            $wpdb->insert($wpdb->prefix . 'pass_qr', $userPassTb);
            var_dump($wpdb->last_error);
            echo "<- pass_qr <br>";
            $this->i++;
        }
    }

}

?>
<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
include_once(ABSPATH  . '/wp-config.php');
include_once(ABSPATH  . '/wp-load.php');
include_once(ABSPATH . '/wp-includes/wp-db.php');
include_once ('param2.php');

function wp2_generate_password( $length = 12, $special_chars = true, $extra_special_chars = false ) {
	$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ123456789';
	if ( $special_chars )
		$chars .= '!@#$%^&*()';
	if ( $extra_special_chars )
		$chars .= '-_ []{}<>~`+=,.;:/?|';

	$password = '';
	for ( $i = 0; $i < $length; $i++ ) {
		$password .= substr($chars, wp_rand(0, strlen($chars) - 1), 1);
	}

	/**
	 * Filter the randomly-generated password.
	 *
	 * @since 3.0.0
	 *
	 * @param string $password The generated password.
	 */
	return apply_filters( 'random_password', $password );
}

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
    
    function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}   
    
    function canti($cant = 50,$event='') {
        $qrFactory = new qr();
        global $wpdb;
        While ($this->i < $cant) {
            $this->lastId = $wpdb->get_var("SELECT id from " . $wpdb->prefix . "users order by id desc limit 1",0,0);
            $this->lastId = $this->lastId + 1;
            $this->passusr = wp2_generate_password(8, false);
            $this->pass = wp_hash_password($this->passusr);
            $this->nombreUsuario = $this->lastId .'-'. $this->generateRandomString(4); 
            $this->correo = $this->nombreUsuario . '@lifeband.com';
            $usersTb = array(
                'user_login' => $this->nombreUsuario,
                'user_email' => $this->correo,
                'user_pass' => $this->pass,
                'user_registered' => gmdate('Y-m-d H:i:s'),
                'user_status' => 0
            );
            if(empty($event)){
                $userPassTb = array('pass' => $this->passusr,'id_user' => $this->lastId,);
            }else{
                $userPassTb = array('pass' => $this->passusr,'id_user' => $this->lastId,'id_evento' => $event,);
            }
            $wpdb->insert($wpdb->prefix . 'users', $usersTb);
            $this->usersMetaInsert($this->lastId, $this->nombreUsuario);
            $wpdb->insert($wpdb->prefix . 'pass_qr', $userPassTb);
            $qrFactory->crearQrPNG('lifeband.com.mx/qr?code=',$this->nombreUsuario);
            $this->i++;
        }
    }
    
    function deleteUserByEvent($eventId)
    {
        $wpdb->query('CALL `deleteUserByEventId` ('.$eventId.')');
        
    }
    function deleteUserById($userId)
    {
        $wpdb->query('CALL `deleteUserById` ('.$userId.')');
        
    }
    function deleteEventById($eventId)
    {
        $wpdb->query('CALL `deleteEventById` ('.$eventId.')');
        
    }
    
}
?>
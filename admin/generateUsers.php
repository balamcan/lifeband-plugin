<?php 
	global $wpdb;
	include_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/wp-includes/wp-db.php');
	
	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
}
	class generateUsers{
			global $i = 0;
			global $nombreUsuario = '';
			global $pass = '';
			global $lastId = 0;
		function canti($cant=50){
			
			While ($i <= $cant) DO{
				$lastId = $wpdb->get_var("SELECT id INTO lastId from ". $wpdb->prefix."users order by id desc limit 1");
				$lastId = $lastId + 1;
				$passusr = wp_generate_password(8);
				$pass = wp_hash_password($passusr);
				$nombreUsuario = substr(sha1(lastId),1,4).strrev(lastId);
				$correo = $nombreUsuario.'@lifeband.com';

				
				$usersTb = array(
			        'user_nicename' => $nombreUsuario,
			        'email' => $correo,
			        'password' => $pass,
			        'user_registered' => gmdate('Y-m-d H:i:s'),
			        'user_status' => 0
			    );
			    $usermetaTb = array(
					'nickname'=> $nombreUsuario,
					'rich_editing'=>'true',
					'comment_shortcuts'=> 'false',
					'admin_color'=> 'fresh',
					'use_ssl'=> '0',
					'show_admin_bar_front'=> 'true'),
					'wp_capabilities'=> 'a:1:{s:10:"subscriber";b:1;}',
					'wp_user_level'=> '0',
					'dismissed_wp_pointers'=> 'wp330_toolbar,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link,wp350_media,wp360_revisions,wp360_locks';
				);
				$userPassTb = array('id' => $lastId,
				'pass' => $passusr );

				$wpdb->insert($wpdb->prefix.'users', $usersTb);
				$wpdb->insert($wpdb->prefix.'usermeta', $usermetaTb);
				$wpdb->insert($wpdb->prefix.'pass_qr', $userPassTb);
				$i++;
			}

	}

	}

?>
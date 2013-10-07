<?php
include_once ('param2.php');
include_once(ABSPATH . '/wp-includes/wp-db.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb;
$plugin_directory=plugins_url().'/lifeband-plugin/';
$url=urlencode($_SERVER['HTTP_HOST'].'/qr?code=');
//<td><a href="http://'.$_SERVER['HTTP_HOST'].'/qr/param2.php?a[]='.
//        $u->username .'&url='.$url.'">QR '.$u->username .'</a></td>
?>
<div class="wrap">
    <h3>Usuarios generados</h3>
<!--<a href="<?php // echo'http://'.$_SERVER['HTTP_HOST'].'/qr/param2.php?'.$a_build.'&'.'url='.$url;?>">Generar los QRs de los usuarios</a>-->
<a href="<?php echo'http://'.$_SERVER['HTTP_HOST'].'/qr/img/index.php';?>">Ver los archivos QRs generados</a>
<table>
    <tr><th>ID<th>Nombre usuario</th><th>Contrase&ntilde;a</th><th>Accesar al QR</th></tr>
    <?php
    $usuarios = $wpdb->get_results('select u.ID, u.user_login as username, p.pass from wp_users as u RIGHT JOIN wp_pass_qr as p on u.id = p.id_user', OBJECT);
    foreach ($usuarios as $u) {
//        $qrFactory = new qr();
//        $qrFactory->crearQrUsuario($u->username);
        echo'<tr><td>' . $u->ID . '</td><td>' . $u->username . '</td><td>' . $u->pass 
        . '</td><td><a href="http://'.$_SERVER['HTTP_HOST'].'/qr/img/'.$u->username .'.png">QR </a></td></tr>';
    }
    ?>
</table>
</div>
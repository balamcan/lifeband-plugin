<?php
//require_once('generateUsers.php');
include_once(ABSPATH . '/wp-includes/wp-db.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//$userFactory = new generateUsers();
//if (isset($_POST['submit'])) {
//    $userFactory->canti();
//    echo "50 Usuarios Generados";
//}
$a = array();
global $wpdb;

$usuarios = $wpdb->get_results('select u.ID, u.user_login as username, p.pass from wp_users as u RIGHT JOIN wp_pass_qr as p on u.id = p.id_user', OBJECT);
    foreach ($usuarios as $u) {
        $a[]=$u->username ;
    }
$url=urlencode($_SERVER['HTTP_HOST'].'/sitio/qr?code=');
//$a_build=http_build_query($a);
$a_build=  implode('&a[]=', $a);
?>


<div class="wrap">
    <h3>Usuarios generados</h3>
<!--    <form method="post" action="<?php //echo $_SERVER['REQUEST_URI']; ?>">
        <input type="button" name="submit" value="Generar los QRs de los usuarios">
        <input type="hidden" name="users" value="1">
    </form>-->
<a href="<?php echo'http://'.$_SERVER['HTTP_HOST'].'/qr/param2.php?'.$a_build.'&'.'url='.$url;?>">Generar los QRs de los usuarios</a>
<table>
    <tr><th>ID<th>Nombre usuario</th><th>Contrase&ntilde;a</th></tr>
    <?php
    $usuarios = $wpdb->get_results('select u.ID, u.user_login as username, p.pass from wp_users as u RIGHT JOIN wp_pass_qr as p on u.id = p.id_user', OBJECT);
    foreach ($usuarios as $u) {
        echo'<tr><td>' . $u->ID . '</td><td>' . $u->username . '</td><td>' . $u->pass . '</td></tr>';
    }
    ?>
</table>
</div>
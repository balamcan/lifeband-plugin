<?php
require_once('generateUsers.php');
include_once(ABSPATH . '/wp-includes/wp-db.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
$userFactory = new generateUsers();
if(isset($_POST['submit'])) { 
    $userFactory->canti();
    echo "50 Usuarios Generados";
} 
?>


<div class="wrap">

<h2>Life Band Plugin</h2>

<h3>Life Band Plugin Options</h3>

<form method="post" action="/wordpress/wp-content/plugins/lifeband-plugin/admin/lifeband-plugin-admin.php">
<input type="button" name="submit" value="Generar 50 usuarios">
</form>
</div>
<table>
<tr><th>Nombre usuario</th><th>Contrase&ntilde;a</th></tr>
<?php 
global $wpdb;
$usuarios=$wpdb->get_results('select u.user_login as username, p.pass from wp_users as u LEFT JOIN wp_pass_qr as p on u.id = p.id_user', OBJECT);
foreach ($usuarios as $u) {
echo'<tr><td>'.$u->username.'</td><td>'.$u->pass.'</td></tr>';
}
?>
</table>
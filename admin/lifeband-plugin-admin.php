<?php
if (!empty($_POST['submitted'])) {
require_once('generateUsers.php');
include_once(ABSPATH . '/wp-includes/wp-db.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
$userFactory = new generateUsers();
    $userFactory->canti();
    echo "50 Usuarios Generados";
}
?>


<div class="wrap">
    <h2>Life Band Plugin</h2>
    <h3>Life Band Plugin Options</h3>

    <form method="post" action="<?php echo plugins_url( 'lifeband-plugin\admin\lifeband-plugin-admin.php'); ?>">
        <input type="button" name="submit" value="Generar 50 usuarios">
        <input type="hidden" name="submitted" value="1">
    </form>
</div>

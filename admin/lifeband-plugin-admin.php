<?php
if (!empty($_POST['generar_fs'])) {
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

    <form method="post" action="<?php echo  $_SERVER['REQUEST_URI']; ?>">
        <text type="text" name="cantidad">
        <input type="submit" name="submit" value="Generar 50 usuarios">
        <input type="hidden" name="generar_fs" value="1">
    </form>
</div>

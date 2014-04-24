<?php
if (!empty($_POST['cantidad_fs'])) {
    $cantidad=$_POST['cantidad_fs'];
    require_once('generateUsers.php');
    include_once(ABSPATH . '/wp-includes/wp-db.php');
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $userFactory = new generateUsers();
    $userFactory->canti($cantidad);
    echo "<b>{$cantidad}</b> Usuarios Generados";
}
?>


<div class="wrap">
    <h2>Life Band Plugin</h2>
    <h3>Life Band Plugin Options</h3>

    <form method="post" action="<?php echo  $_SERVER['REQUEST_URI']; ?>">
        <div class="row">
           <label for="cantidad">Cantidad de usuarios a generar:</label>
            <text type="text" name="cantidad_fs" id="cantidad" value="50">
        </div>
        <div class="row">
           <label for="cantidad">Cantidad de usuarios a generar:</label>
            <text type="text" name="cantidad_fs" id="cantidad" value="50">
        </div>
        <div class="row">
            <input type="submit" name="submit" value="Generar 50 usuarios">
        </div>
    </form>
</div>

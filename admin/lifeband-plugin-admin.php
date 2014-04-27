<?php
if (!empty($_POST['cantidad_fs'])) {
    $cantidad=$_POST['cantidad_fs'];
    if (!empty($_POST['evento_fs'])) {
        $evento=$_POST['evento_fs'];
    }
    require_once('generateUsers.php');
    include_once(ABSPATH . '/wp-includes/wp-db.php');
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    ##se necesitan los usuairos asignados aa un evento como parametro en generateUsers con el id del evento definido
    $userFactory = new generateUsers();
    $userFactory->canti($cantidad);
    echo "<b>{$cantidad}</b> Usuarios Generados";
}
?>

<style type="text/css">
    .row{
        width: 90%;
    }
    .row input[type="text"], .row select, .row label{
        display: inline-block;
    }
    
    .row label{
        margin: 12px;
        text-align: right;
        width: 25%;
    }
    .row input[type="text"], .row select{
        margin: 3px;
    }
</style>
<div class="wrap">
    <h2>Life Band Plugin</h2>
    <h3>Generador de usuarios</h3>

    <form method="post" action="<?php echo  $_SERVER['REQUEST_URI']; ?>">
        <div class="row">
           <label for="cantidad">Cantidad de usuarios a generar:</label>
            <input type="text" name="cantidad_fs" id="cantidad" value="50">
        </div>
        <div class="row">
           <label for="evento">Asignados al evento temporalmente:</label>

            <select type="text" name="evento_fs" id="evento" value="50">
                <option value="">Ninguno</option>
            </select>
        </div>
        <div class="row">
            <input type="submit" name="submit" value="Generar usuarios">
        </div>
    </form>
</div>

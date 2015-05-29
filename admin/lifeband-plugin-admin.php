<?php
include_once(ABSPATH . '/wp-includes/wp-db.php');
global $wpdb;
require_once('generateUsers.php');
$userFactory = new generateUsers();
if (!empty($_POST['cantidad_fs'])) {
    $evento='';
    $cantidad=$_POST['cantidad_fs'];
    if (!empty($_POST['evento_fs'])) {
        $evento=$_POST['evento_fs'];
    }
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    ##se necesitan los usuairos asignados aa un evento como parametro en generateUsers con el id del evento definido
    
    $userFactory->canti($cantidad,$evento);
    echo "<b>{$cantidad}</b> Usuarios Generados";
}
if(!empty($_POST['evento_a_borrar_fs'])) {
         $eventoQueSeraBorrado =$_POST['evento_a_borrar_fs'];
         $userFactory->deleteUserByEvent($eventoQueSeraBorrado);
}
$eventos = $wpdb->get_results('select id, nombre from '.$wpdb->prefix.'evento as e where activo = 1', OBJECT);
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

            <select  name="evento_fs" id="evento">
                <option value="">Ninguno</option>
                <?php 
                    foreach ($eventos as $e) {
                        echo'<option value="'.$e->id.'">'.$e->nombre.'</option>';
                    }
                 ?>
            </select>
        </div>
        <div class="row">
            <input type="submit" name="submit" value="Generar usuarios">
        </div>
    </form>
    <h3>Borrar Usuarios</h3>
    <label for="evento">Borrar Usuario por evento:</label>
    <form method="post" action="<?php echo  $_SERVER['REQUEST_URI']; ?>">
        
        <div class="row">
           <label for="evento">Seleccione Evento:</label>

            <select  name="evento_a_borrar_fs" id="evento_a_borrar">
                
                <?php 
                    foreach ($eventos as $e) {
                        echo'<option value="'.$e->id.'">'.$e->nombre.'</option>';
                    }
                 ?>
            </select>
        </div>
        <div class="row">
            <input type="submit" name="submit" value="Borrar Usuarios">
        </div>
    </form>
</div>

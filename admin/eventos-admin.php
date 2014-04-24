<?php
if (!empty($_POST['campo_fs'])) {
//    $cantidad=$_POST['cantidad_fs'];
//    require_once('generateUsers.php');
    include_once(ABSPATH . '/wp-includes/wp-db.php');
//    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//    $userFactory = new generateUsers();
//    $userFactory->canti($cantidad);
//    echo "<b>{$cantidad}</b> Usuarios Generados";
}
?>


<div class="wrap">
    <h2>Life Band Plugin</h2>
    <h3>Administracion de evenots</h3>
    <i>Nota: Por cuestion de futuros procesos de analisis se recomienda llenar todos los campos</i>
    <br>
    <i>Los campos que contienen * son requeridos</i>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <!-- Si el evento ya existe mostrar el siguiente div-->
        <div class="row">
            <label for="nombre">Id del evento:</label>
            <div id="div-id_evento"></div>
        </div>
        <div class="row">
            <label for="nombre">Nombre:</label>
            <text type="text" name="nombre_fs" id="nombre" required="required">
        </div>
        <div class="row">
            <label for="fecha_i">Fecha inicio:</label>
            <text type="text" name="fecha_i_fs" id="fecha_i">
        </div>
        <div class="row">
            <label for="hora_i">Hora de inicio:</label>
            <text type="text" name="hora_i_fs" id="hora_i">
        </div>
        <div class="row">
            <label for="fecha">Fecha termino:</label>
            <text type="text" name="fecha_fs" id="fecha">
        </div>
        <div class="row">
            <label for="hora_t">Hora de termino:</label>
            <text type="text" name="hora_t_fs" id="hora_t">
        </div>
        <div class="row">
            <label for="lugar">Lugar:</label>
            <text type="text" name="lugar_fs" id="lugar">
        </div>
        <div class="row">
            <label for="descripcion">Descripcion:</label>
            <text type="text" name="descripcion_fs" id="descripcion">
        </div>
        <div class="row">
            <input type="submit" name="submit" value="Guardar evento">
            <input type="hidden" name="id_evento_fs" id="id_evento">
            <!-- Si el evento es nuevo, poner el boton crear evento nuevo-->
            <input type="button" name="nuevo_evento_fs" id="nuevo_evento" value="Crear evento nuevo">
        </div>
    </form>
    <div class="paginacion">

    </div>
    <table>
        <thead>
            <tr> 
                <th>ID</th> <th>Nombre</th> <th>F Inicio</th> <th>H Inicio</th> <th>F Termino</th> <th>H termino</th> <th>Descripcion</th> <th>Lugar</th>
                <th><a href="<?php echo $_SERVER['REQUEST_URI'] . "editar_fs=" . $id; ?>">Editar</a></th> 
                <th><a href="<?php echo $_SERVER['REQUEST_URI'] . "borrar_fs=" . $id; ?>">Borrar</a></th> 
            </tr>
        </thead>
        <tbody>
            <tr> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
            </tr>
        </tbody>
    </table>
    <div class="paginacion">

    </div>
</div>

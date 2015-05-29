<?php
include_once(ABSPATH . '/wp-includes/wp-db.php');
global $wpdb;
$mensaje = '';
    function respuesta($tipo) {
        if ($tipo == 'error') {
            return '<h2 class="error">
            No se pudo guardar correctamente
            </h2>';
        } else {

            return '<h2 class="success">
            Se guardo correctamente
            </h2>';
        }
    }
if(!empty($_GET['editar_fs']) ){


    if (isset($_GET['activar_fs'])) {
        if ($wpdb->update(            
            $wpdb->prefix . 'evento', array(
                'activo' => mysql_real_escape_string($_GET['activar_fs']),
                ), array('id' => mysql_real_escape_string($_GET['editar_fs']))
            ) == FALSE)
            $mensaje=respuesta('error');
        else
            $mensaje=respuesta('success');
    }else
    $e_evento = $wpdb->get_row('select id, nombre, date(f_inicio) as f_inicio, time(f_inicio) as h_inicio, date(f_termino) as f_termino,
        time(f_termino) as h_termino, lugar, descripcion, activo from '.$wpdb->prefix.'evento as e WHERE id ='.$_GET['editar_fs'], OBJECT);
}

if (!empty($_POST)) {
//    $cantidad=$_POST['cantidad_fs'];
//    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    ##INSERTANDO
    
$inicio=null;
$termino=null;

if (!empty($_POST['f_inicio_fs']) || !empty($_POST['h_inicio_fs'])) {
    $f_inicio = $_POST['f_inicio_fs'] . ' ' . $_POST['h_inicio_fs'];
    $o_inicio = new DateTime($f_inicio);
    $inicio=$o_inicio->format('c');
}

if (!empty($_POST['f_termino_fs']) || !empty($_POST['h_termino_fs'])) {
    $f_termino = $_POST['f_termino_fs'] . ' ' . $_POST['h_termino_fs'];
    $o_termino = new DateTime($f_termino);
    $termino=$o_termino->format('c');

}
    if (empty($_POST['activo_fs'])) {
        $_POST['activo_fs'] = 0;
    }
    if (!empty($_POST['id_evento_fs'])) {
        $id_evento = $_POST['id_evento_fs'];
    }

    if (empty($id_evento)) {
        if ($wpdb->insert(
                        $wpdb->prefix . 'evento', array(
                    'nombre' => mysql_real_escape_string($_POST['nombre_fs']),
                    'f_inicio' => mysql_real_escape_string($inicio),
                    'f_termino' => mysql_real_escape_string($termino),
                    'lugar' => mysql_real_escape_string($_POST['lugar_fs']),
                    'descripcion' => mysql_real_escape_string($_POST['descripcion_fs']),
                    'activo' => mysql_real_escape_string($_POST['activo_fs']),
                        )
                ) == FALSE) {
            $mensaje=respuesta('error');
        } else {
            $mensaje=respuesta('success');
        }
    } else {
        if ($wpdb->update(            
                        $wpdb->prefix . 'evento', array(
                    'nombre' => mysql_real_escape_string($_POST['nombre_fs']),
                    'f_inicio' => mysql_real_escape_string($inicio),
                    'f_termino' => mysql_real_escape_string($termino),
                    'lugar' => mysql_real_escape_string($_POST['lugar_fs']),
                    'descripcion' => mysql_real_escape_string($_POST['descripcion_fs']),
                    'activo' => mysql_real_escape_string($_POST['activo_fs']),
                        ), array('id' => mysql_real_escape_string($id_evento))
                ) == FALSE)
            $mensaje=respuesta('error');
        else
            $mensaje=respuesta('success');
    }
}
$eventos = $wpdb->get_results('select id, nombre, date(f_inicio) as f_inicio, time(f_inicio) as h_inicio, date(f_termino) as f_termino,
time(f_termino) as h_termino, lugar, descripcion, activo from '.$wpdb->prefix.'evento as e', OBJECT);
// <<<<<<< Updated upstream
// =======

$correos = $wpdb->get_results('SELECT c.*, e.nombre as evento FROM '.$wpdb->prefix.'correos_evento as c '
        . 'LEFT JOIN '.$wpdb->prefix.'evento as e on c.id_'.$wpdb->prefix.'evento = e.id', ARRAY_A);


if (!empty($_GET['pagina'])) {
    $inicio = $_GET['pagina'];
}
else{
	$inicio = 1;
} 
$fin = 2;
$result = $wpdb->get_results('SELECT c.*, e.nombre as evento FROM '.$wpdb->prefix.'correos_evento as c '
        . 'LEFT JOIN '.$wpdb->prefix.'evento as e on c.id_'.$wpdb->prefix.'evento = e.id limit ' . $inicio . ','.$fin, ARRAY_A);
$qNumberOfRows = $wpdb->get_row('SELECT Count(*) as number FROM '.$wpdb->prefix.'correos_evento', ARRAY_A);

$numberOfRows = ceil($qNumberOfRows->number / $fin);
//$numberOfRows = $numberOfRows ;
// $paginator = paginator($numberOfRows, $inicio);
// >>>>>>> Stashed changes
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
<link rel="stylesheet" href="http://lifeband.com.mx/wp-content/plugins/lifeband-plugin/admin/css/jquery-ui-1.10.4.custom.css">
<script src="http://lifeband.com.mx/wp-content/plugins/lifeband-plugin/admin/js/jquery-1.10.2.js"></script>
<script src="http://lifeband.com.mx/wp-content/plugins/lifeband-plugin/admin/js/jquery-ui-1.10.4.custom.min.js"></script>

<!--
<link rel="stylesheet" href="/resources/demos/style.css">
-->
<script>
    $(function() {
        $("#f_inicio").datepicker();
        $("#f_termino").datepicker();
    });
</script>
<div class="wrap">
    <div id="mensaje">
        <?php
        if (!empty($mensaje)) {
            echo $mensaje;
        }
        ?>
    </div>
</div>
<div class="wrap">
    <h2>Life Band Plugin</h2>
    <h3>Administracion de eventos</h3>
    <i>Nota: Por cuestion de futuros procesos de analisis se recomienda llenar todos los campos</i>
    <br>
    <i>Los campos que contienen * son requeridos</i>
    <br>
    <i>Importante:Si contiene un valor el campo de "Id del evento" significa que se está editando</i>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <!-- Si el evento ya existe mostrar el siguiente div-->
        <div class="row">
            <label for="div-id_evento">Id del evento:</label>
            <!--div id="div-id_evento"></div-->
            <input type="text" readonly="readonly" name="id_evento_fs" id="id_evento" value="<?php echo $e_evento->id;?>">
        </div>
        <div class="row">
            <label for="nombre">*Nombre:</label>
            <input type="text" name="nombre_fs" id="nombre" required="required" value="<?php echo $e_evento->nombre;?>">
        </div>
        <div class="row">
            <label for="fecha_i">Fecha inicio:</label>
            <input type="text" name="f_inicio_fs" id="f_inicio" value="<?php echo $e_evento->f_inicio;?>">
        </div>
        <div class="row">
            <label for="hora_i">Hora de inicio:</label>
            <input type="text" name="h_inicio_fs" id="h_inicio" value="<?php echo $e_evento->h_inicio;?>">
        </div>
        <div class="row">
            <label for="fecha">Fecha termino:</label>
            <input type="text" name="f_termino_fs" id="f_termino" value="<?php echo $e_evento->f_termino;?>">
        </div>
        <div class="row">
            <label for="hora_t">Hora de termino:</label>
            <input type="text" name="h_termino_fs" id="h_termino" value="<?php echo $e_evento->h_termino;?>">
        </div>
        <div class="row">
            <label for="lugar">Lugar:</label>
            <input type="text" name="lugar_fs" id="lugar" value="<?php echo $e_evento->lugar;?>">
        </div>
        <div class="row">
            <label for="descripcion">Descripcion:</label>
            <input type="text" name="descripcion_fs" id="descripcion" value="<?php echo $e_evento->descripcion;?>">
        </div>
        <div class="row">
            <label for="activo">Activo:</label>
            <input type="checkbox" name="activo_fs" id="activo" value="1" checked="<?php echo ((!isset($e_evento))?'checked':(($e_evento->activo == 1)?'checked':''));?>">
        </div>
        <div class="row">
            <input type="submit" name="submit" value="Guardar evento">
            <!-- Si el evento es nuevo, poner el boton crear evento nuevo-->
            <input type="button" name="nuevo_evento_fs" id="nuevo_evento" value="Crear evento nuevo" onclick=" window.location='http://lifeband.com.mx/wp-admin/admin.php?page=lifeband-plugin-event-menu';">
        </div>
    </form>
    <div class="paginacion">

    </div>
    <table>
        <thead>
            <tr> 
                <th>Id</th>
                <th>Nombre</th>
                <th>F Inicio</th>
                <th>H Inicio</th>
                <th>F Termino</th> 
                <th>H termino</th>
                <th>Descripcion</th>
                <th>Lugar</th>
                <th>Activo</th>
                <th>Acciones</th>
                <th>Imprimir QRs</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($eventos as $e) {
//        $qrFactory = new qr();
//        $qrFactory->crearQrUsuario($e->username);

                echo'<tr> 
                <td>' . $e->id . '</td> 
                <td>' . $e->nombre . '</td> 
                <td>' . $e->f_inicio . '</td> 
                <td>' . $e->h_inicio . '</td> 
                <td>' . $e->f_termino . '</td> 
                <td>' . $e->h_termino . '</td> 
                <td>' . $e->descripcion . '</td> 
                <td>' . $e->lugar . '</td> 
                <td>' . (($e->activo == 1)?'Si':'No') . '</td> 
                <td>
                    <a href="http://lifeband.com.mx/wp-admin/admin.php?page=lifeband-plugin-event-menu&editar_fs= ' . $e->id . '">Editar</a> 
                    |
                    <a href="http://lifeband.com.mx/wp-admin/admin.php?page=lifeband-plugin-event-menu&editar_fs= '.$e->id.'&activar_fs= '.(($e->activo=='1')?'0':'1'). '">Activo</a> 
                </td> 
                
                <td>

                <a href="http://lifeband.com.mx/printqr/?id= ' . $e->id . '">QRs</a>&nbsp;
                <a href="http://lifeband.com.mx/printqr2/?id= ' . $e->id . '">Medalla grande</a>&nbsp;
                <a href="http://lifeband.com.mx/printqr3/?id= ' . $e->id . '">Pulsera</a>&nbsp;
                <a href="http://lifeband.com.mx/printqr4/?id= ' . $e->id . '">Medalla chica</a>&nbsp;
                <a href="http://lifeband.com.mx/printqrrecipe/?id= ' . $e->id . '">Instructivo</a>

                </td> 
            </tr>';
            }
            ?>

        </tbody>
    </table>
    <div class="paginacion">

    </div>
</div>

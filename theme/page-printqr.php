<?php
/*
 * Template Name: printqr
 */
include_once(ABSPATH . '/wp-includes/wp-db.php');
global $wpdb;

global $avia_config;
$id=$_GET['id'];
$evento=$wpdb->get_row('select nombre from '.$wpdb->prefix .'evento where id = '.  mysql_real_escape_string($id),OBJECT);
$usuarios = $wpdb->get_results('select u.ID, u.user_login as username, p.pass from '.$wpdb->prefix .'users as u RIGHT JOIN '.$wpdb->prefix .'pass_qr as p on u.id = p.id_user where id_evento ='.  mysql_real_escape_string($id), OBJECT);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Imprimir QRs de evento generados</title>
    <style type="text/css">
    body{
        font-family: Arial;
    }
    .etiqueta{
        width: 160px;
        height: 89px;
        border: 4px solid #000;
        display: inline-block;
        margin: 5px;
    }
    .qr{
        width: 50px;
        height: 50px;
        border: 1px solid #000;
        display: block;
        float: left;
    }
    .info{
        display: block;
        float: left;
        width: 75px;
        height: 80px;
        padding: 3px 4px 3px 8px;
        text-align: right;
        font-size: 10px;
        border-left: 2px dotted #000;
    }
    .referencia{
        font-style: italic;
    }
    .valor{
        font-weight: bold;
    }
    .marca{
        height: 18px;
    }
    .left{
        float: left;
    }
    .qr-info{
        width: 55px;
        height: 55px;
        float: left;
        margin: 3px 5px 3px 9px;
    }
    .aviso{
        text-align: center;
        font-size: 6px;
    }
    .block-center{
        margin:0 -2px;
    }
    </style>
</head>
<body>
    <h1><?php echo $evento->nombre;?></h1>
<?php 
    foreach ($usuarios as $u) {
        echo'<div class="etiqueta">
            <div class="qr-info">
                <img src="http://lifeband.com.mx/images/logolb.png" alt="" class="marca left block-center">
                <img src="http://lifeband.com.mx/qrphp/img/'.$u->username.'.png" alt="" class="qr">
                <div class="aviso">Escanearse en caso de emergencia</div>
            </div>
            <div class="info">
                <img src="http://lifeband.com.mx/images/logolb.png" alt="" class="marca">
                <div class="referencia">Usuario:</div>
                <div class="valor">'.$u->username.'</div>
                <div class="referencia">Contraseña:</div>
                <div class="valor">'.$u->pass.'</div>
            </div>
        </div>';
    }
 ?>
</body>
</html>

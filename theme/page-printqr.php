<?php
/*
 * Template Name: printqr
 */

include_once(ABSPATH . '/wp-includes/wp-db.php');
global $wpdb;


global $avia_config;



$usuarios = $wpdb->get_results('select u.ID, u.user_login as username, p.pass from wp_users as u RIGHT JOIN wp_pass_qr as p on u.id = p.id_user where id_evento =1', OBJECT);
var_dump($usuarios);
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
        width: 124px;
        height: 71px;
        border: 2px solid #000;
        display: inline-block;
        margin: 5px;
    }
    .qr{
        width: 55px;
        height: 55px;
        border: 1px solid #000;
        display: block;
        float: left;
        margin: 7px 5px 7px 9px;
    }
    .info{
        display: block;
        float: left;
        width: 49px;
        height: 55px;
        padding: 7px 4px 8px 0px;
        text-align: right;
        font-size: 8px;
    }
    .referencia{
        font-style: italic;
    }
    .valor{
        font-weight: bold;
    }
    .marca{
        height: 14px;
    }
    </style>
</head>
<body>
<?php 
    foreach ($usuarios as $u) {
        echo'<div class="etiqueta">
            <img src="http://lifeband.com.mx/qrphp/img/'.$u->username.'.png" alt="" class="qr">
            <div class="info">
                <img src="http://lifeband.com.mx/wp-content/themes/enfold/images/logolb.png" alt="" class="marca">
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
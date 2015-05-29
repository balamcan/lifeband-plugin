<?php
/*
 * Template Name: printqr4
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
@media print{
    body{
        font-family: Arial;
    }
    .etiqueta{
        width: 77px;
        height: 131px;
        border: 1px solid #fff;
        display: inline-block;
        margin: 5px;
        border-radius: 30px;
    }
    .etiqueta > img, .etiqueta > div{
        display: inline-block;
    }
    .qr{
        width: 56px;
        height: 56px;
        border: 1px solid #000;
    }
    
    .circulo{
        width: 10px;
        height: 10px;
        border-radius: 10px;
        margin: 7px 35px 3px;
        background-color: transparent;
        display: block;
    }
    .recorte{
        text-align: center;
        width:77px;
        height: 105px; 
        display: block;
        margin: 0 auto;
        border: 1px dotted #000;
    }
    .recorte2{
        border: 1px solid #fff;
        border-radius: 10px;
        display: block;
        height: 105px;
        margin: -1px;
        width: 77px;
    }
    .referencia{
        font-style: italic;
        font-size: 7px;
        font-family: Verdana;
        font-weight: bold;
    }
    .valor{
        font-weight: bold;
    }
    .marca{
        margin-bottom: 3px;
        height: 9px;
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
        font-size: 5px;
    }
    .block-center{
        margin:0 auto;
    }
}
@media screen{
    body{
        font-family: Arial;
    }
    .etiqueta{
        width: 77px;
        height: 131px;
        border: 1px solid #ccc;
        display: inline-block;
        margin: 5px;
        border-radius: 30px;
    }
    .etiqueta > img, .etiqueta > div{
        display: inline-block;
    }
    .qr{
        width: 56px;
        height: 56px;
        border: 1px solid #000;
    }
    
    .circulo{
        width: 10px;
        height: 10px;
        border-radius: 10px;
        margin: 7px 35px 3px;
        background-color: #ccc;
        display: block;
    }
    .recorte{
        text-align: center;
        width:77px;
        height: 105px; 
        display: block;
        margin: 0 auto;
        border: 1px dotted #000;
    }
    .recorte2{
        border: 1px solid #fff;
        border-radius: 10px;
        display: block;
        height: 105px;
        margin: -1px;
        width: 77px;
    }
    .referencia{
        font-style: italic;
        font-size: 7px;
        font-family: Verdana;
        font-weight: bold;
    }
    .valor{
        font-weight: bold;
    }
    .marca{
        margin-bottom: 3px;
        height: 9px;
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
        font-size: 5px;
    }
    .block-center{
        margin:0 auto;
    }
}
    
    </style>
</head>
<body>
    <h1><?php echo $evento->nombre;?></h1>
<?php 
    foreach ($usuarios as $u) {
        echo'<div class="etiqueta">
            <div class="circulo"></div>
            <div class="recorte">
                <div class="recorte2">
                    <img src="http://lifeband.com.mx/images/badges/logo-bgbadge.png" alt="" class="marca">
                    <img src="http://lifeband.com.mx/qrphp/img/'.$u->username.'.png" alt="" class="qr">
                    <div class="aviso">ESCANEAR EN EMERGENCIA</div>
                    <div class="aviso">SCAN IN EMERGENCY</div>
                    <div class="referencia">'.$u->username.'</div>
                </div>
            </div>
        </div>';
    }
?>
</body>
</html>

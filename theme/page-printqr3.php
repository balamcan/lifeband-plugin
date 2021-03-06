<?php
/*
 * Template Name: printqr3
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
        width: 127px;
        height: 73px;
        border: 1px solid #fff;
        display: inline-block;
        margin: 5px;
        border-radius: 40px;
    }
    .qr{
        width: 46px;
        height: 46px;
        border: 1px solid #000;
        display: block;
        float: left;
        margin: 8px 0;
        padding-left: 2px;
    }
    
    .circulo-left{
        width: 10px;
        height: 10px;
        border-radius: 10px;
        background-color: transparent;
        display: block;
        position: relative;
        top: 31px;
        left: 7px;
        float: left;
    }
      .circulo-right{
        width: 10px;
        height: 10px;
        border-radius: 10px;
        background-color: transparent;
        display: block;
        position: relative;
        top: 31px;
        left: 110px;
    }
    .recorte{
        text-align: center;
        width:106px;
        height: 64px; 
        display: block;
        margin: -7px 17px;
        border: 1px dotted #000;
        float: left;
    }
    .recorte2{
        border: 2px solid #fff;
        border-radius: 10px;
        display: block;
        float: left;
        height: 63px;
        margin: -1px;
        width: 105px;
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
        margin-top: 2px;
        margin-bottom: 3px;
        height: 7px;
        display: inline-block;
        margin-right: 5px;
        margin-top: 5px;
    }
    .left{
        float: left;
    }
    .qr-info{
        width: 50px;
        height: 55px;
        float: left;
        margin-left: 2px;
        padding-right: 2px;
    }
    .aviso{
        text-align: left;
        font-size: 5px;
        padding-left: 3px;
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
        width: 127px;
        height: 73px;
        border: 1px solid #ccc;
        display: inline-block;
        margin: 5px;
        border-radius: 40px;
    }
    .qr{
        width: 46px;
        height: 46px;
        border: 1px solid #000;
        display: block;
        float: left;
        margin: 8px 0;
        padding-left: 2px;
    }
    
    .circulo-left{
        width: 10px;
        height: 10px;
        border-radius: 10px;
        background-color: #ccc;
        display: block;
        position: relative;
        top: 31px;
        left: 7px;
        float: left;
    }
      .circulo-right{
        width: 10px;
        height: 10px;
        border-radius: 10px;
        background-color: #ccc;
        display: block;
        position: relative;
        top: 31px;
        left: 110px;
    }
    .recorte{
        text-align: center;
        width:106px;
        height: 64px; 
        display: block;
        margin: -7px 17px;
        border: 1px dotted #000;
        float: left;
    }
    .recorte2{
        border: 2px solid #fff;
        border-radius: 10px;
        display: block;
        float: left;
        height: 63px;
        margin: -1px;
        width: 105px;
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
        margin-top: 2px;
        margin-bottom: 3px;
        height: 7px;
        display: inline-block;
        margin-right: 5px;
        margin-top: 5px;
    }
    .left{
        float: left;
    }
    .qr-info{
        width: 50px;
        height: 55px;
        float: left;
        margin-left: 2px;
        padding-right: 2px;
    }
    .aviso{
        text-align: left;
        font-size: 5px;
        padding-left: 3px;
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
            <div class="circulo-left"></div>
            <div class="recorte">
                <div class="recorte2">
                    <img src="http://lifeband.com.mx/qrphp/img/'.$u->username.'.png" alt="" class="qr">
                    <div class="qr-info">
                        <img src="http://lifeband.com.mx/images/badges/logo-smbadge.png" alt="" class="marca">
                        <div class="aviso">ESCANEAR EN EMERGENCIA</div>
                        <div class="aviso">SCAN IN EMERGENCY</div>
                        <div class="referencia">'.$u->username.'</div>
                    </div>
                </div>
            </div>
            <div class="circulo-right"></div>
        </div>';
    }
?>
</body>
</html>

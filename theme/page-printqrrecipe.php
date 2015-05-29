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

    body{
        font-family: Arial;
    }
    .etiqueta{
        width: 318px;
        height: 177px;
        border: 1px solid #000;
        display: inline-block;
        margin: 5px;
    }
    .referencia{
        font-size: 16px;
        font-family: Verdana;
    }
    .valor{
        font-weight: bold;
        font-size: 20px;
    }
    .header{
        background-color: red;
        width: 318px;
        height: 27px;
        padding-top: 4px;
    }
    .marca{
        display: block;
        margin: 0 auto;
        width: 140px;
        height: 22px;
    }
    .left{
        float: left;
    }
    .qr-info{
        width: 55px;
        height: 55px;
        float: left;
        margin-left: 2px;
    }
    .aviso{
        text-align: center;
        font-size: 6px;
        margin-top: 2px;
    }
    .block-center{
        margin:0 auto;
    }
    .recipe{
        width: 140px;
        height: 145px;
        padding: 0 10px;
        float: left;
        border-right: 1px dotted #ccc;
    }
    .recipe>ol{
        font-size: 8.5px;
        text-align: justify;
        margin: 0;
        padding: 0 5px;
    }
    .recipe>ol>li{
        margin: 7px 0;
    }
    .recipe .titulo{
        text-align: center;
        width: 100%;
        margin-top: 5px;
    }
    .values{
        width: 149px;
        height: 145px;
        float: left;
        margin-top: 5px;
        text-align: center;
        line-height: 30px;
    }
.underline{
    text-decoration: underline;
    font-style: italic;
}
    </style>
</head>
<body>
    <h1><?php echo $evento->nombre;?></h1>
<?php 
    foreach ($usuarios as $u) {
        echo'<div class="etiqueta">
        <div class="header">
            <img src="http://lifeband.com.mx/images/badges/logo-recipe.png" alt="" class="marca">
        </div>
        <div class="recipe">
            <div class="titulo">Instrucciones</div>
            <ol>
                <li>
                    Ingresa a <span class="underline">www.lifeband.com.mx</span> usando este usuario y contraseña.
                </li>
                <li>
                    Cambia el usuario por tu correo electrónico y una nueva contraseña.
                </li>
                <li>
                    Registra tus datos básicos y médicos para así disfrutar de los beneficios de Lifeband.
                </li>
            </ol>
        </div>
        <div class="values">
            <div class="referencia">Usuario</div>
            <div class="valor">'.$u->username.'</div>
            <div class="referencia">Contraseña</div>
            <div class="valor">'.$u->pass.'</div>
        </div>
    </div>';
    }
?>
</body>
</html>

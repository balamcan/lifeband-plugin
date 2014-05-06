<?php
include_once ('param2.php');
include_once(ABSPATH . '/wp-includes/wp-db.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb;
$registros_pagina=100;
$paginacion = array();
$inicio = 0;
$pagina = 1;
$plugin_directory = plugins_url() . '/lifeband-plugin/';
$url = urlencode($_SERVER['HTTP_HOST'] . '/qr?code=');
//<td><a href="http://'.$_SERVER['HTTP_HOST'].'/qr/param2.php?a[]='.
//        $u->username .'&url='.$url.'">QR '.$u->username .'</a></td>

if (!empty($_GET['num_reg_fs'])) {
    $registros_pagina = $_GET['num_reg_fs'];
} 


if (!empty($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
    $inicio = ($pagina - 1 ) * $registros_pagina;
}
$registros = $wpdb->get_results('select count(u.ID) as total from wp_users as u RIGHT JOIN wp_pass_qr as p on u.id = p.id_user', OBJECT);
#$c_total_registros="select count(*) from %tabla%";
$total_registros = intval($registros["total"]);
$total_paginas = ceil($total_registros / $registros_pagina);


#$c_consulta= 'select * from %tabla% limit '.$inicio.','.$registros_pagina;
//$usuarios = $wpdb->get_results('select u.ID, u.user_login as username, p.pass from wp_users as u RIGHT JOIN wp_pass_qr as p on u.id = p.id_user limit ' . $inicio . ',' . $registros_pagina, OBJECT);
#$r_consulta=mysql_query(query);
####################CODIGO PARA MOSTRAR LA PAGINACION#######

if ($total_paginas > 1) {
    for ($i = 0; $i <= $total_paginas; $i++) {
        if ($pagina == 1) {
            $paginacion[] = $pagina . ' ';
        } else {
            $paginacion[] = '<a href="&pagina=' . $i . '">' . $i . '</a>';
        }
    }
}
/*
var_dump($total_paginas);
var_dump($total_registros);
var_dump($registros);*/
?>
<div class="wrap">
    <h3>Usuarios generados</h3>
    <!--<a href="<?php // echo'http://'.$_SERVER['HTTP_HOST'].'/qrphp/param2.php?'.$a_build.'&'.'url='.$url;  ?>">Generar los QRs de los usuarios</a>-->
    <a href="<?php echo'http://' . $_SERVER['HTTP_HOST'] . '/qrphp/img/index.php'; ?>">Ver los archivos QRs generados</a>
</div>
<div class="wrap">
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <h3>Borrar usuarios por evento</h3>
        <div class="row">
            <label for="borrar_usuarios_evento">Borrar usuarios vinculados del evento:</label>
            <select name="borrar_usuarios_evento_fs" id="borrar_usuarios_evento">
                <option value="">Ninguno</option>
            </select>
        </div>
    </form>
</div>
<div class="wrap">
    <div class="paginacion">
<?php #echo implode(" | ", $paginacion)?>
    </div>
    <table>
        <thead>
            <tr><th>ID<th>Nombre usuario</th><th>Contrase&ntilde;a</th><th>Accesar al QR</th><th>Evento</th></tr>
        </thead>
        <tbody>
<?php
$usuarios = $wpdb->get_results('select u.ID, u.user_login as username, p.pass from wp_users as u RIGHT JOIN wp_pass_qr as p on u.id = p.id_user', OBJECT);
foreach ($usuarios as $u) {
//        $qrFactory = new qr();
//        $qrFactory->crearQrUsuario($u->username);
    echo'<tr><td>' . $u->ID . '</td><td>' . $u->username . '</td><td>' . $u->pass
    . '</td><td><a href="http://' . $_SERVER['HTTP_HOST'] . '/qrphp/img/' . $u->username . '.png">QR </a></td></tr>';
}
?>
        </tbody>
    </table>
    <div class="paginacion">
<?php# echo implode(" | ", $paginacion)?>
    </div></div>
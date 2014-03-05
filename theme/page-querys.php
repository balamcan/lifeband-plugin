<?php
/*
 * Template Name: Qr
 */
global $avia_config;

function edad($edad) {
    if (!isset($edad)) {
        list($anio, $mes, $dia) = explode("-", $edad);
        $anio_dif = date("Y") - $anio;
        $mes_dif = date("m") - $mes;
        $dia_dif = date("d") - $dia;
        if ($mes_dif == 0 && $dia_dif < 0 || $mes_dif < 0)
            $anio_dif--;
        return $anio_dif;
    }else {
        return false;
    }
}
function lifeband_plugin_update() {
    //Do some installation work
    global $wpdb;
//    $template_directory=get_template_directory();
//    $plugin_directory=plugins_url().'/lifeband-plugin/';
//    $copy_files=array();
//    $f_functions=null;
    //the others tables

    $wpdb->query("ALTER TABLE `wp_datos_basicos`
ADD COLUMN `encargado_emergencia2` VARCHAR(70) NULL DEFAULT NULL  AFTER `sexo` , 
ADD COLUMN `tel_emergencia2` VARCHAR(45) NULL DEFAULT NULL  AFTER `encargado_emergencia2` ,
ADD COLUMN `encargado_emergencia3` VARCHAR(70) NULL DEFAULT NULL  AFTER `tel_emergencia2` ,
ADD COLUMN `tel_emergencia3` VARCHAR(45) NULL DEFAULT NULL  AFTER `encargado_emergencia3` ,
ADD COLUMN `nom_medico2` VARCHAR(70) NULL DEFAULT NULL  AFTER `tel_emergencia3` ,
ADD COLUMN `tel_medico2` VARCHAR(45) NULL DEFAULT NULL  AFTER `nom_medico2` ,
ADD COLUMN `nom_medico3` VARCHAR(70) NULL DEFAULT NULL  AFTER `tel_medico2` ,
ADD COLUMN `tel_medico3` VARCHAR(45) NULL DEFAULT NULL  AFTER `nom_medico3` ,
ADD COLUMN `no_pasaporte` VARCHAR(50) NULL DEFAULT NULL  AFTER `tel_medico3` ;");

    $wpdb->query("ALTER TABLE `wp_datos_medicos` 
ADD COLUMN `servicio_medico2` VARCHAR(50) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT NULL  AFTER `med_natural` ,
ADD COLUMN `vacunas` TEXT CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NULL DEFAULT NULL  AFTER `servicio_medico2` ;");

    $wpdb->query("DROP TABLE IF EXISTS `wp_datos_medicos_disp_capacidades` ;");

    $wpdb->query("DROP TABLE IF EXISTS `wp_cat_disp_discapacidades` ;");


    /*
      $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_pass_qr` (`id` int(11) NOT NULL AUTO_INCREMENT, `pass` varchar(10) NOT NULL, `id_user` bigint(20) DEFAULT NULL, PRIMARY KEY (`id`) ) DEFAULT CHARSET=utf8;");
      $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_datos_medicos` (`id` int(11) NOT NULL AUTO_INCREMENT, `wp_users_id` int(11) NOT NULL, `wp_cat_tipo_sangre_id` int(11) DEFAULT NULL, `wp_cat_tipo_diabetes_id` int(11) NOT NULL, `presion_arterial_diastolica` int(11) DEFAULT NULL, `presion_arterial_sistolica` int(11) DEFAULT NULL, `donador_organos` tinyint(1) DEFAULT NULL, `alergias` text, `medicamentos` text, `enfermedades` text, `cirugias` text, `otras_consideraciones` text, `d_auditiva` text, `d_mental` text, `d_motora` text, `d_visual` text, `marcapasos` text, `lentes_contacto` text, `p_dentales` text, `p_oculares` text, `med_natural` text, PRIMARY KEY (`id`), KEY `fk_wp_dat_med_wp_users1_idx` (`wp_users_id`), KEY `fk_wp_dat_med_wp_cat_tipo_san_idx` (`wp_cat_tipo_sangre_id`), KEY `fk_wp_datos_medicos_wp_cat_tipo_diab_idx` (`wp_cat_tipo_diabetes_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");
      $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_datos_basicos` (`id` int(11) NOT NULL AUTO_INCREMENT, `wp_users_id` int(11) NOT NULL, `nombre` varchar(120) NOT NULL, `ap_paterno` varchar(55) DEFAULT NULL, `ap_materno` varchar(55) DEFAULT NULL, `encargado_emergencia` varchar(70) DEFAULT NULL, `tel_emergencia` varchar(45) DEFAULT NULL, `correo_emergencia` varchar(70) DEFAULT NULL, `nom_medico` varchar(70) DEFAULT NULL, `tel_medico` varchar(45) DEFAULT NULL, `fecha_nac` date DEFAULT NULL, `peso` decimal(2,0) DEFAULT NULL, `estatura` decimal(4,2) DEFAULT NULL, `sexo` varchar(1) DEFAULT NULL, PRIMARY KEY (`id`), KEY `fk_wp_datos_basicos_wp_users1_idx` (`wp_users_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
     */
}
lifeband_plugin_update();
function link_telefono($telefono=''){
    if($telefono !== ''){
        return '<a href=tel://"'.$telefono.'">'.$telefono.'</a>';
    }else{
        return false;
    }
}

get_header();
$codigo = $_GET['code'];
$error = '';
$sucess = '';
//gives the full url
$urlqr = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
if (is_user_logged_in() && empty($codigo)) {

    $current_user = wp_get_current_user();
    $codigo = $current_user->user_login;
    $urlqr.='?code=' . $codigo;
}

if (!empty($codigo)) {

    $q_user = 'select ID from ' . $wpdb->prefix . 'users where user_login = \'' . $codigo . '\'';
    $user = $wpdb->get_row($q_user, OBJECT);
}
if (!empty($user)) {

    $q_basicos = 'select * from ' . $wpdb->prefix . 'datos_basicos where ' . $wpdb->prefix . 'users_id = ' . $user->ID;
    $basicos = $wpdb->get_row($q_basicos, OBJECT);

    $q_medicos = 'select * from ' . $wpdb->prefix . 'datos_medicos where ' . $wpdb->prefix . 'users_id = ' . $user->ID;
    $medicos = $wpdb->get_row($q_medicos, OBJECT);

    if (!empty($medicos)) {
        $q_tipo_sangre = 'select nombre from ' . $wpdb->prefix . 'cat_tipo_sangre where id = ' . $medicos->wp_cat_tipo_sangre_id;
        $tipo_sangre = $wpdb->get_row($q_tipo_sangre, OBJECT);
        $medicos->tipo_sangre = $tipo_sangre->nombre;

        $q_tipo_diabetes = 'select nombre from ' . $wpdb->prefix . 'cat_tipo_diabetes where id = ' . $medicos->wp_cat_tipo_diabetes_id;
        $tipo_diabetes = $wpdb->get_row($q_tipo_diabetes, OBJECT);
        $medicos->tipo_diabetes = $tipo_diabetes->nombre;
    }
} else {
    if (empty($_GET['code'])) {
        $error = 'Error: No hay codigo';
    } else {
        $error = 'Error: No existe el usuario';
    }
}
if (get_post_meta(get_the_ID(), 'header', true) != 'no')
    echo avia_title();
?>
<div class='container_wrap main_color <?php avia_layout_class('main'); ?>'>

    <div class='container'>

        <div class='template-page content  <?php avia_layout_class('content'); ?> units'>

            <?php
            $avia_config['size'] = avia_layout_class('main', false) == 'entry_without_sidebar' ? '' : 'entry_with_sidebar';

            while (have_posts()) : the_post();
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?> -<b><?php
            echo $basicos->nombre . ' ' .
            $basicos->ap_paterno . ' ' . $basicos->ap_materno
                ?></b></h1>
                        <?php
                        if (is_user_logged_in())
                            echo' 
                                <a href="' . 'http://' . $_SERVER['HTTP_HOST'] . '/datos-basicos/' . '"><b>Modificar mis datos basicos </b></a> 
                                <a href="' . 'http://' . $_SERVER['HTTP_HOST'] . '/datos-medicos/' . '"><b>Modificar mis datos medicos</b></a> 
                                <a href="' . 'http://' . $_SERVER['HTTP_HOST'] . '/confirmar-datos/?hash=540f6f564efghahk' . '"><b>Cambiar contrase&ntilde;a</b></a>';
                        ?>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>

                        <style type="text/css">
                            #consult-qr h2{
                                text-align: center;
                            }
                            #consult-qr h3{
                                border-bottom: 2px solid #ccc;
                                padding: 1.2rem;
                            }
                            #consult-qr p{
                                line-height: 1.21429;
                                margin: 0 0 1.21429rem;
                                width: auto;
                            }
                            #consult-qr label{
                                width: 35%;
                                text-align: right;
                                margin: 0 0.71429rem;
                                display: inline-block;
                            }
                            #consult-qr span{
                                margin: 0 0.71429rem;
                            }
                            #consult-qr .qr img, #consult-qr .qr p{
                                margin: 1.2em auto;
                                display: block;
                                text-align: center;
                            }
                        </style>

                        <div id="consult-qr">
                            <?php
                            if (!empty($error)) {
                                echo '<h2 style="color:red;">' . $error . '</h2>';
                            }
                            if (!empty($success)) {
                                echo '<h2 style="color:green;">' . $success . '</h2>';
                            }
                            ?>

                            <h3>Datos b&aacute;sicos</h3>
                            <p><label>Apellido paterno:</label><span><?php echo$basicos->ap_paterno; ?></span></p>
                            <p><label>Apellido materno:</label><span><?php echo$basicos->ap_materno; ?></span></p>
                            <p><label>Nombre:</label><span><?php echo$basicos->nombre; ?></span></p>
                            <p><label>Nombre del encargado de emergencia:</label><span><?php echo$basicos->encargado_emergencia; ?></span></p>
                            <p><label>Telefono de emergencia:</label><span><?php echo link_telefono($basicos->tel_emergencia); ?></span></p>
                            <p><label>Correo de emergencia:</label><span><?php echo$basicos->correo_emergencia; ?></span></p>
                            <p><label>Nombre del medico:</label><span><?php echo$basicos->nom_medico; ?></span></p>
                            <p><label>Telefono del medico:</label><span><?php echo link_telefono($basicos->tel_medico); ?></span></p>
                            <p><label>Edad:</label><span><?php 
                            echo edad($basicos->fecha_nac)?' a&ntilde;os':'';
                            ?></span></p>
                            <p><label>Peso:</label><span><?php echo$basicos->peso . ' Kilogramos'; ?></span></p>
                            <p><label>Estatura:</label><span><?php echo$basicos->estatura . ' Metros'; ?></span></p>
                            <p><label>Sexo:</label><span><?php echo$basicos->sexo; ?></span></p>

                            <h3>Datos medicos</h3>

                            <p><label>Tipo de sangre:</label><span><?php echo$medicos->tipo_sangre; ?></span></p>
                            <p><label>Tipo de diabetes:</label><span><?php echo$medicos->tipo_diabetes; ?></span></p>
                            <p><label>Presi&oacute;n arterial diastolica:</label><span><?php echo$medicos->presion_arterial_diastolica; ?></span></p>
                            <p><label>Presi&oacute;n arterial sistolica:</label><span><?php echo$medicos->presion_arterial_sistolica; ?></span></p>
                            <p><label>Donador de organos:</label><span><?php echo(($medicos->donador_organos == 1) ? 'Si' : 'No' ); ?></span></p>

                            <p><label>Servicio medico:</label><span><?php echo$medicos->servicio_medico; ?></span></p>
                            <p><label>Numero de poliza:</label><span><?php echo$medicos->numero_poliza; ?></span></p>
                            <p><label>Embarazada:</label><span><?php echo(($medicos->embarazada == 1) ? 'Si' : 'No' ); ?></span></p>

                            <p><label>Alergias:</label><span><?php echo$medicos->alergias; ?></span></p>
                            <p><label>Medicamentos:</label><span><?php echo$medicos->medicamentos; ?></span></p>
                            <p><label>Enfermedades:</label><span><?php echo$medicos->enfermedades; ?></span></p>
                            <p><label>Cirug&iacute;as:</label><span><?php echo$medicos->cirugias; ?></span></p>
                            <p><label>Otras consideraciones:</label><span><?php echo$medicos->otras_consideraciones; ?></span></p>

                            <h3>Discapacidades y/o dispositivos</h3>

                            <p><label>Discapacidad auditiva:</label><span><?php echo$medicos->d_auditiva; ?></span></p>
                            <p><label>Discapacidad mental:</label><span><?php echo$medicos->d_mental; ?></span></p>
                            <p><label>Discapacidad motora:</label><span><?php echo$medicos->d_motora; ?></span></p>
                            <p><label>Discapacidad visual:</label><span><?php echo$medicos->d_visual; ?></span></p>
                            <p><label>Dispositivo de soporte vital marcapasos:</label><span><?php echo$medicos->marcapasos; ?></span></p>
                            <p><label>Lentes de contacto:</label><span><?php echo$medicos->lentes_contacto; ?></span></p>
                            <p><label>Protesis dentales:</label><span><?php echo$medicos->p_dentales; ?></span></p>
                            <p><label>Medicamentos de origen natural:</label><span><?php echo$medicos->med_natural; ?></span></p>
                            <div class="qr">
    <!--                                <form action="<?php //permalink_link()      ?>">
                                    <input type="submit" value="Enviar correo al medico">
                                    <input type="hidden" name="submitted" value="1">
                                </form>-->
                                <?php
//                            echo '<img src="http://'.$_SERVER['HTTP_HOST']'.'/qr/param.php?txt=' . $urlqr . '"/>';
                                echo '<img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl=http://' . $urlqr . '"/>';
                                echo'<p>' . 'http://' . $urlqr . '</p>';
                                ?>
                            </div>
                            <a href="<?php echo home_url(); ?>">Ir a inicio</a>
                        </div>

                    </div><!-- .entry-content -->

                </article><!-- #post -->

            <?php endwhile; // end of the loop.        ?>

        </div><!-- #content -->
        <?php
        //get the sidebar
        $avia_config['currently_viewing'] = 'page';
        // get_sidebar();
        ?>
    </div><!-- #primary -->


    <?php
    //get_footer(); ?>
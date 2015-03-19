<?php
/*
 * Template Name: Qr
 */
global $avia_config;

function edad($edad) {
    if (!empty($edad)) {
        list($anio, $mes, $dia) = explode("-", $edad);
        $anio_dif = date("Y") - $anio;
        $mes_dif = date("m") - $mes;
        $dia_dif = date("d") - $dia;
        if ($mes_dif == 0 && $dia_dif < 0 || $mes_dif < 0)
            $anio_dif--;
        return $anio_dif;
    }else {
        return '';
    }
}

function link_telefono($telefono = '') {
    if ($telefono !== '') {
        return '<a href=tel://"' . $telefono . '">' . $telefono . '</a>';
    } else {
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

    $q_basicos = 'select * from ' . $wpdb->prefix . 'datos_basicos where ' . 'wp_users_id = ' . $user->ID;
    $basicos = $wpdb->get_row($q_basicos, OBJECT);

    $q_medicos = 'select * from ' . $wpdb->prefix . 'datos_medicos where ' .  'wp_users_id = ' . $user->ID;
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
                                <a href="' . 'http://' . $_SERVER['HTTP_HOST'] . '/datos-basicos/' . '"><b>Modificar mis datos b&aacute;sicos </b></a> |
                                <a href="' . 'http://' . $_SERVER['HTTP_HOST'] . '/datos-medicos/' . '"><b>Modificar mis datos m&eacute;dicos</b></a> |
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
                            #archivo{
                                width: 100%;
                                height: auto;
                                background-color: #ccc;
                                border: solid #A81010 thick;
                                }
                            @media only screen and (min-width: 480px) {
                                #archivo{
                                    width: 40%;
                                }
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
                            <?php
                            if (!empty($basicos->foto))

                                echo'<p><label>Foto /Picture:</label><span> <img id="archivo" src="' . content_url().'/fotos/' . $basicos->foto . '"></span></p>';

                            if (!empty($basicos->ap_paterno))
                                echo'<p><label>Apellido paterno / Last Name:</label><span>' . $basicos->ap_paterno . '</span></p>';

                            if (!empty($basicos->ap_materno))
                                echo'<p><label>Apellido materno / Maternal Surname:</label><span>' . $basicos->ap_materno . '</span></p>';

                            if (!empty($basicos->nombre))
                                echo'<p><label>Nombre / Name:</label><span>' . $basicos->nombre . '</span></p>';

                            if (!empty($basicos->encargado_emergencia))
                                echo'<p><label>Nombre del encargado de emergencia / Emergency Manager Name:</label><span>' . $basicos->encargado_emergencia . '</span></p>';

                            if (!empty($basicos->tel_emergencia))
                                echo'<p><label>Tel&eacute;fono de emergencia / Emergency Phone:</label><span>' . link_telefono($basicos->tel_emergencia) . '</span></p>';

                            if (!empty($basicos->encargado_emergencia2))
                                echo'<p><label>Nombre encargado de emergencia adicional / Additional emergency manager name:</label><span>' . $basicos->encargado_emergencia2 . '</span></p>';

                            if (!empty($basicos->tel_emergencia2))
                                echo'<p><label>Tel&eacute;fono de emergencia encargado adicional /  Additional Emergency Phone:</label><span>' . link_telefono($basicos->tel_emergencia2) . '</span></p>';

                            if (!empty($basicos->encargado_emergencia3))
                                echo'<p><label>Nombre encargado de emergencia adicional 2 / Additional Emergency Phone:</label><span>' . $basicos->encargado_emergencia3 . '</span></p>';

                            if (!empty($basicos->tel_emergencia3))
                                echo'<p><label>Tel&eacute;fono de emergencia encargado adicional 2 / Additional Emergency Phone:</label><span>' . link_telefono($basicos->tel_emergencia3) . '</span></p>';

                            if (!empty($basicos->correo_emergencia))
                                echo'<p><label>Correo de emergencia / Emergency mail:</label><span>' . $basicos->correo_emergencia . '</span></p>';

                            if (!empty($basicos->nom_medico))
                                echo'<p><label>Nombre del m&eacute;dico / Name of doctor:</label><span>' . $basicos->nom_medico . '</span></p>';

                            if (!empty($basicos->tel_medico))
                                echo'<p><label>Tel&eacute;fono del m&eacute;dico / Phone Numberr:</label><span>' . link_telefono($basicos->tel_medico) . '</span></p>';

                            if (!empty($basicos->nom_medico2))
                                echo'<p><label>Nombre m&eacute;dico adiconal / Additional Doctor:</label><span>' . $basicos->nom_medico2 . '</span></p>';

                            if (!empty($basicos->tel_medico2))
                                echo'<p><label>Tel&eacute;fono m&eacute;dico adicional / Additional Phone Number:</label><span>' . link_telefono($basicos->tel_medico2) . '</span></p>';

                            if (!empty($basicos->nom_medico3))
                                echo'<p><label>Nombre m&eacute;dico adicional 2 / Name of Doctor 2:</label><span>' . $basicos->nom_medico3 . '</span></p>';

                            if (!empty($basicos->tel_medico3))
                                echo'<p><label>Tel&eacute;fono m&eacute;dico adicional 2 / Phone Number from the Additional Doctor:</label><span>' . link_telefono($basicos->tel_medico3) . '</span></p>';

                            if (!empty($basicos->no_pasaporte))
                                echo'<p><label>Numero de pasaporte / Number of passport:</label><span>' . $basicos->no_pasaporte . '</span></p>';

                            if (!empty($basicos->fecha_nac))
                                echo'<p><label>Edad / Age :</label><span>' . edad($basicos->fecha_nac) . '</span></p>';

                            if (!empty($basicos->peso))
                                echo'<p><label>Peso / Weight:</label><span>' . $basicos->peso . ' Kilogramos' . '</span></p>';

                            if (!empty($basicos->estatura))
                                echo'<p><label>Estatura / Height:</label><span>' . $basicos->estatura . ' Metros' . '</span></p>';

                            if (!empty($basicos->sexo))
                                echo'<p><label>Sexo / Genre :</label><span>' . $basicos->sexo . '</span></p>';
                            ?>    

                            <h3>Datos m&eacute;dicos</h3>

                            <?php
                            if (!empty($medicos->tipo_sangre))
                                echo'<p><label>Tipo de sangre / Blood Type:</label><span>' . $medicos->tipo_sangre . '</span></p>';

                            if (!empty($medicos->tipo_diabetes))
                                echo'<p><label>Tipo de diabetes / Type of Diabetes:</label><span>' . $medicos->tipo_diabetes . '</span></p>';
                            
                            if (!empty($medicos->presion_arterial_sistolica))
                                echo'<p><label>Presi&oacute;n arterial sistolica / Systolic Blood Pressure:</label><span>' . $medicos->presion_arterial_sistolica . '</span></p>';
                            
                            if (!empty($medicos->presion_arterial_diastolica))
                                echo'<p><label>Presi&oacute;n arterial diastolica / Diastolic blood pressure:</label><span>' . $medicos->presion_arterial_diastolica . '</span></p>';

                            if (!empty($medicos->donador_organos))
                                echo'<p><label>Donador de &oacute;rganos / Organ Donor:</label><span>' . (($medicos->donador_organos == 1) ? 'Si' : 'No' ) . '</span></p>';

                            if (!empty($medicos->servicio_medico))
                                echo'<p><label>Servicio m&eacute;dico /  Health Insurance:</label><span>' . $medicos->servicio_medico . '</span></p>';

                            if (!empty($medicos->servicio_medico2))
                                echo'<p><label>Segundo servicio m&eacute;dico /  Health Insurance 2:</label><span>' . $medicos->servicio_medico2 . '</span></p>';

                            if (!empty($medicos->numero_poliza))
                                echo'<p><label>Numero de poliza / Policy Number:</label><span>' . $medicos->numero_poliza . '</span></p>';

                            if (!empty($medicos->embarazada))
                                echo'<p><label>Embarazada / pregnant:</label><span>' . (($medicos->embarazada == 1) ? 'Si' : 'No' ) . '</span></p>';

                            if (!empty($medicos->alergias))
                                echo'<p><label>Alergias / Allergies:</label><span>' . $medicos->alergias . '</span></p>';

                            if (!empty($medicos->medicamentos))
                                echo'<p><label>Medicamentos / Medicament:</label><span>' . $medicos->medicamentos . '</span></p>';

                            if (!empty($medicos->enfermedades))
                                echo'<p><label>Enfermedades / Diseases:</label><span>' . $medicos->enfermedades . '</span></p>';

                            if (!empty($medicos->cirugias))
                                echo'<p><label>Cirug&iacute;as / Surgeries:</label><span>' . $medicos->cirugias . '</span></p>';

                            if (!empty($medicos->otras_consideraciones))
                                echo'<p><label>Otras consideraciones / Other Considerations:</label><span>' . $medicos->otras_consideraciones . '</span></p>';
                            ?>
                            <h3>Discapacidades y/o dispositivos</h3>
                            <?php
                            if (!empty($medicos->d_auditiva))
                                echo'<p><label>Discapacidad auditiva / Hearing Impaired:</label><span>' . $medicos->d_auditiva . '</span></p>';

                            if (!empty($medicos->d_mental))
                                echo'<p><label>Discapacidad mental / Mental disability:</label><span>' . $medicos->d_mental . '</span></p>';

                            if (!empty($medicos->d_motora))
                                echo'<p><label>Discapacidad motora / Physical disability:</label><span>' . $medicos->d_motora . '</span></p>';

                            if (!empty($medicos->d_visual))
                                echo'<p><label>Discapacidad visual / visual impairment:</label><span>' . $medicos->d_visual . '</span></p>';

                            if (!empty($medicos->marcapasos))
                                echo'<p><label>Dispositivo de soporte vital marcapasos / Life support device pacemaker:</label><span>' . $medicos->marcapasos . '</span></p>';

                            if (!empty($medicos->lentes_contancto))
                                echo'<p><label>Lentes de contacto / Contact Lenses:</label><span>' . $medicos->lentes_contacto . '</span></p>';

                            if (!empty($medicos->p_dentales))
                                echo'<p><label>Pr&oacute;tesis dentales / Dentals prosthesis:</label><span>' . $medicos->p_dentales . '</span></p>';

                            if (!empty($medicos->med_natural))
                                echo'<p><label>Medicamentos de origen natural / Drugs of natural origin:</label><span>' . $medicos->med_natural . '</span></p>';

                            if (!empty($medicos->vacunas))
                                echo "<p><label>Vacunas aplicadas / Vaccines Given:</label><span>" . $medicos->vacunas . " </span></p>";
                            ?>
                            <div class="qr">
    <!--                                <form action="<?php //permalink_link()            ?>">
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

<?php endwhile; // end of the loop.           ?>

        </div><!-- #content -->
<?php
//get the sidebar
$avia_config['currently_viewing'] = 'page';
// get_sidebar();
?>
    </div><!-- #primary -->


<?php
//get_footer(); ?>
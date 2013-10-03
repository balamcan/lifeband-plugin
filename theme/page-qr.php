<?php
/*
 * Template Name: Qr
 */
get_header();
$codigo = $_GET['code'];

//gives the full url
$urlqr = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
if (!empty($codigo)) {
    $q_user = 'select ID from ' . $wpdb->prefix . 'users where user_login = \'' . $codigo . '\'';
    $user = $wpdb->get_row($q_user, OBJECT);
}
if (!empty($user)) {

    $q_basicos = 'select * from ' . $wpdb->prefix . 'datos_basicos where ' . $wpdb->prefix . 'users_id = ' . $user->ID;
    $basicos = $wpdb->get_row($q_basicos, OBJECT);

    $q_medicos = 'select * from ' . $wpdb->prefix . 'datos_medicos where ' . $wpdb->prefix . 'users_id = ' . $user->ID;
    $medicos = $wpdb->get_row($q_medicos, OBJECT);

    $q_tipo_sangre = 'select nombre from ' . $wpdb->prefix . 'cat_tipo_sangre where id = ' . $medicos->wp_cat_tipo_sangre_id;
    $tipo_sangre = $wpdb->get_row($q_tipo_sangre, OBJECT);
    $medicos->tipo_sangre = $tipo_sangre->nombre;

    $q_tipo_diabetes = 'select nombre from ' . $wpdb->prefix . 'cat_tipo_diabetes where id = ' . $medicos->wp_cat_tipo_diabetes_id;
    $tipo_diabetes = $wpdb->get_row($q_tipo_diabetes, OBJECT);
    $medicos->tipo_diabetes = $tipo_diabetes->nombre;
} else {
    $error = 'No existe el usuario';
}
?>

<div id="primary" class="site-content">
    <div id="content" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?> -<b> Informaci&oacute;n de <?php echo $basicos->nombre . ' ' .
            $basicos->ap_paterno . ' ' . $basicos->ap_materno
            ?></b></h1>
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
                        ?>

                        <h3>Datos b&aacute;sicos</h3>
                        <p><label>Apellido paterno:</label><span><?php echo$basicos->ap_paterno; ?></span></p>
                        <p><label>Apellido materno:</label><span><?php echo$basicos->ap_materno; ?></span></p>
                        <p><label>Nombre:</label><span><?php echo$basicos->nombre; ?></span></p>
                        <p><label>Nombre del encargado de emergencia:</label><span><?php echo$basicos->encargado_emergencia; ?></span></p>
                        <p><label>Telefono de emergencia:</label><span><?php echo$basicos->tel_emergencia; ?></span></p>
                        <p><label>Correo de emergencia:</label><span><?php echo$basicos->correo_emergencia; ?></span></p>
                        <p><label>Nombre del medico:</label><span><?php echo$basicos->nom_medico; ?></span></p>
                        <p><label>Telefono del medico:</label><span><?php echo$basicos->tel_medico; ?></span></p>
                        <p><label>Fecha de nacimiento:</label><span><?php echo$basicos->fecha_nac; ?></span></p>
                        <p><label>Peso:</label><span><?php echo$basicos->peso; ?></span></p>
                        <p><label>Estatura:</label><span><?php echo$basicos->estatura; ?></span></p>
                        <p><label>Sexo:</label><span><?php echo$basicos->sexo; ?></span></p>

                        <h3>Datos medicos</h3>

                        <p><label>Tipo de sangre:</label><span><?php echo$medicos->tipo_sangre; ?></span></p>
                        <p><label>Tipo de diabetes:</label><span><?php echo$medicos->tipo_diabetes; ?></span></p>
                        <p><label>Presi&oacute;n arterial diastolica:</label><span><?php echo$medicos->presion_arterial_diastolica; ?></span></p>
                        <p><label>Presi&oacute;n arterial sistolica:</label><span><?php echo$medicos->presion_arterial_sistolica; ?></span></p>
                        <p><label>Donador de organos:</label><span><?php echo$medicos->donador_organos; ?></span></p>
                        <p><label>Alergias:</label><span><?php echo$medicos->alergias; ?></span></p>
                        <p><label>Medicamentos:</label><span><?php echo$medicos->medicamentos; ?></span></p>
                        <p><label>Enfermedades:</label><span><?php echo$medicos->enfermedades; ?></span></p>
                        <p><label>Cirugias:</label><span><?php echo$medicos->cirugias; ?></span></p>
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
                            <?php
//                            echo '<img src="http://localhost/qr/param.php?txt=' . $urlqr . '"/>';
                            echo '<img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl=http://' . $urlqr . '"/>';
                            echo'<p>' . 'http://' . $urlqr . '</p>';
                            ?>
                        </div>
                    </div>

                </div><!-- .entry-content -->

            </article><!-- #post -->

        <?php endwhile; // end of the loop.   ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
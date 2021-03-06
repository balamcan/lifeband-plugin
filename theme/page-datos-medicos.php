<?php
/*
 * Template Name: Datos basicos
 */
global $avia_config;
global $wpdb;
//response generation function
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
    }
}
$response = "";

//wp_redirect('http://'.$_SERVER['HTTP_HOST'].'/qr/');
//function to generate response
function my_contact_form_generate_response($type, $message) {
    global $response;
    $url_redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/qr/';
    if ($type == "success") {
        if($message == 'sincambios'){
            $response = "<div class='success'>{$message}
            <a href='{$url_redirect}'>Para ver tus datos cuando se acceda por el QR haz click aqui</a>
            </div>";
        }else{
            $response = "<div class='success'>{$message}
            <a href='{$url_redirect}'>Para ver tus datos cuando se acceda por el QR haz click aqui</a>
            </div>";
        }
    } else
        $response = "<div class='error'>{$message}</div>";
}

//response messages
$not_human = "Human verification incorrect.";
$missing_content = "Please supply all information.";
//  $email_invalid   = "Email Address Invalid.";
//  $message_unsent  = "Message was not sent. Try Again.";
//  $message_sent    = "Thanks! Your message has been sent.";
$mensaje = array(
    'nohumano' => 'Favor de llenar la suma',
    'diastolica' => 'Favor de poner la medida de la presion DIASTOLICA',
    'sistolica' => 'Favor de poner la medida de la presion SISTOLICA',
    'guardado' => 'Fue guardado con exito',
    'noguardado' => 'No se pudo guardar',
    'sincambios' => "No hubo cambios.",
);
//user posted variables
//  $name = $_POST['message_name'];
//  $email = $_POST['message_email'];
//  $message = $_POST['message_text'];
$human = $_POST['message_human'];

////php mailer variables
//$to = get_option('admin_email');
//$subject = "Someone sent a message from " . get_bloginfo('name');
//$headers = 'From: ' . $email . "\r\n" .
//        'Reply-To: ' . $email . "\r\n";
$current_user = wp_get_current_user();
$q_user = 'select * from ' . $wpdb->prefix . 'datos_medicos where ' . 'wp_users_id = ' . $current_user->ID;
$user = $wpdb->get_row($q_user, OBJECT);
$q_basicos = 'select sexo from ' . $wpdb->prefix . 'datos_basicos where ' .  'wp_users_id = ' . $current_user->ID;
$basicos = $wpdb->get_row($q_basicos, OBJECT);

//if (!$human == 0) {
//    if ($human != 2)
//        my_contact_form_generate_response("error", $mensaje['nohumamo']); //not human!
//    else {
//        if (!filter_var($_POST['presion_diastolica_fs'], FILTER_VALIDATE_INT))
//            my_contact_form_generate_response("error", $mensaje['diastolica']);
//        else {
//
//            if (!filter_var($_POST['presion_sistolica_fs'], FILTER_VALIDATE_INT))
//                my_contact_form_generate_response("error", $mensaje['sistolica']);
//            else { //ready to go!
/* INSERTAR O ACTUALIZAR LA INFORMACION */
if (!empty($_POST['submitted'])) {
    if (empty($user)) {
        if ($wpdb->insert(
                        $wpdb->prefix . 'datos_medicos', array(
                    'wp_users_id' => mysql_real_escape_string($current_user->ID),
                    'wp_cat_tipo_sangre_id' => mysql_real_escape_string($_POST['tipo_sangre_fs']),
                    'wp_cat_tipo_diabetes_id' => mysql_real_escape_string($_POST['tipo_diabetes_fs']),
                    'presion_arterial_diastolica' => mysql_real_escape_string($_POST['presion_diastolica_fs']),
                    'presion_arterial_sistolica' => mysql_real_escape_string($_POST['presion_sistolica_fs']),
                    'donador_organos' => mysql_real_escape_string($_POST['donador_organos_fs']),
                    'alergias' => mysql_real_escape_string($_POST['alergias_fs']),
                    'medicamentos' => mysql_real_escape_string($_POST['medicamentos_fs']),
                    'enfermedades' => mysql_real_escape_string($_POST['enfermedades_fs']),
                    'cirugias' => mysql_real_escape_string($_POST['cirugias_fs']),
                    'servicio_medico' => mysql_real_escape_string($_POST['servicio_medico_fs']),
                    'servicio_medico2' => mysql_real_escape_string($_POST['servicio_medico2_fs']),
                    'numero_poliza' => mysql_real_escape_string($_POST['numero_poliza_fs']),
                    'embarazada' => mysql_real_escape_string($_POST['embarazada_fs']),
                    'otras_consideraciones' => mysql_real_escape_string($_POST['otras_consideraciones_fs']),
                    'd_auditiva' => mysql_real_escape_string($_POST['auditiva_fs']),
                    'd_mental' => mysql_real_escape_string($_POST['mental_fs']),
                    'd_motora' => mysql_real_escape_string($_POST['motora_fs']),
                    'd_visual' => mysql_real_escape_string($_POST['visual_fs']),
                    'marcapasos' => mysql_real_escape_string($_POST['marcapasos_fs']),
                    'lentes_contacto' => mysql_real_escape_string($_POST['lentes_contacto_fs']),
                    'p_dentales' => mysql_real_escape_string($_POST['protesis_dentales_fs']),
                    'p_oculares' => mysql_real_escape_string($_POST['protesis_oculares_fs']),
                    'med_natural' => mysql_real_escape_string($_POST['med_naturales_fs']),
                    'vacunas' => mysql_real_escape_string($_POST['vacunas_fs'])
                        )
                ) == FALSE) {
            my_contact_form_generate_response("error", $mensaje['noguardado']);
        } else {
            my_contact_form_generate_response("success", $mensaje['guardado']);
        }
    } else {
        if ($wpdb->update(
                        $wpdb->prefix . 'datos_medicos', array(
                    'wp_cat_tipo_sangre_id' => mysql_real_escape_string($_POST['tipo_sangre_fs']),
                    'wp_cat_tipo_diabetes_id' => mysql_real_escape_string($_POST['tipo_diabetes_fs']),
                    'presion_arterial_diastolica' => mysql_real_escape_string($_POST['presion_diastolica_fs']),
                    'presion_arterial_sistolica' => mysql_real_escape_string($_POST['presion_sistolica_fs']),
                    'donador_organos' => mysql_real_escape_string($_POST['donador_organos_fs']),
                    'alergias' => mysql_real_escape_string($_POST['alergias_fs']),
                    'medicamentos' => mysql_real_escape_string($_POST['medicamentos_fs']),
                    'enfermedades' => mysql_real_escape_string($_POST['enfermedades_fs']),
                    'cirugias' => mysql_real_escape_string($_POST['cirugias_fs']),
                    'servicio_medico' => mysql_real_escape_string($_POST['servicio_medico_fs']),
                    'servicio_medico2' => mysql_real_escape_string($_POST['servicio_medico2_fs']),
                    'numero_poliza' => mysql_real_escape_string($_POST['numero_poliza_fs']),
                    'embarazada' => mysql_real_escape_string($_POST['embarazada_fs']),
                    'otras_consideraciones' => mysql_real_escape_string($_POST['otras_consideraciones_fs']),
                    'd_auditiva' => mysql_real_escape_string($_POST['auditiva_fs']),
                    'd_mental' => mysql_real_escape_string($_POST['mental_fs']),
                    'd_motora' => mysql_real_escape_string($_POST['motora_fs']),
                    'd_visual' => mysql_real_escape_string($_POST['visual_fs']),
                    'marcapasos' => mysql_real_escape_string($_POST['marcapasos_fs']),
                    'lentes_contacto' => mysql_real_escape_string($_POST['lentes_contacto_fs']),
                    'p_dentales' => mysql_real_escape_string($_POST['protesis_dentales_fs']),
                    'p_oculares' => mysql_real_escape_string($_POST['protesis_oculares_fs']),
                    'med_natural' => mysql_real_escape_string($_POST['med_naturales_fs']),
                    'vacunas' => mysql_real_escape_string($_POST['vacunas_fs'])
                        ), array('wp_users_id' => mysql_real_escape_string($current_user->ID))
                ) == TRUE)
            my_contact_form_generate_response("success", $mensaje['guardado']);
        else
            my_contact_form_generate_response("success", $mensaje['sincambios']);

    }
}
//else if ($_POST['submitted'])
//    my_contact_form_generate_response("error", $missing_content);
//$medicos = $wpdb->get_row($q_medicos, OBJECT);
//var_dump($user);

if (!empty($user) && empty($_POST)) {
//
//    echo $user->servicio_medico .
//    $user->numero_poliza .
//    $user->embarazada;

    $_POST['tipo_sangre_fs'] = $user->wp_cat_tipo_sangre_id;
    $_POST['tipo_diabetes_fs'] = $user->wp_cat_tipo_diabetes_id;
    $_POST['presion_diastolica_fs'] = $user->presion_arterial_diastolica;
    $_POST['presion_sistolica_fs'] = $user->presion_arterial_sistolica;
    $_POST['donador_organos_fs'] = $user->donador_organos;
    $_POST['alergias_fs'] = $user->alergias;
    $_POST['medicamentos_fs'] = $user->medicamentos;
    $_POST['enfermedades_fs'] = $user->enfermedades;
    $_POST['cirugias_fs'] = $user->cirugias;
    $_POST['servicio_medico_fs'] = $user->servicio_medico;
    $_POST['servicio_medico2_fs'] = $user->servicio_medico2;
    $_POST['numero_poliza_fs'] = $user->numero_poliza;
    $_POST['embarazada_fs'] = $user->embarazada;
    $_POST['otras_consideraciones_fs'] = $user->otras_consideraciones;
    $_POST['auditiva_fs'] = $user->d_auditiva;
    $_POST['mental_fs'] = $user->d_mental;
    $_POST['motora_fs'] = $user->d_motora;
    $_POST['visual_fs'] = $user->d_visual;
    $_POST['marcapasos_fs'] = $user->marcapasos;
    $_POST['lentes_contacto_fs'] = $user->lentes_contacto;
    $_POST['protesis_dentales_fs'] = $user->p_dentales;
    $_POST['protesis_oculares_fs'] = $user->p_oculares;
    $_POST['med_naturales_fs'] = $user->med_natural;
    $_POST['vacunas_fs'] = $user->vacunas;
}


$q_tipo_sangre = 'select * from ' . $wpdb->prefix . 'cat_tipo_sangre';
$tipo_sangre = $wpdb->get_results($q_tipo_sangre, OBJECT);

$q_tipo_diabetes = 'select * from ' . $wpdb->prefix . 'cat_tipo_diabetes';
$tipo_diabetes = $wpdb->get_results($q_tipo_diabetes, OBJECT);
?>

<?php
get_header();
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
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>

                        <style type="text/css">
                            .error{
                                padding: 5px 9px;
                                border: 1px solid red;
                                color: red;
                                border-radius: 3px;
                            }

                            .success{
                                padding: 5px 9px;
                                border: 1px solid green;
                                color: green;
                                border-radius: 3px;
                            }
                            .success a{
                                font-size: 16px;
                                text-decoration: underline;
                            }
                            form span{
                                color: red;
                            }
                            #respond form .one-line label, #respond form .one-line input{
                                display: inline-block;
                            }
                            .consejo{
                                display: inline-block;
                                margin-left: 10px;
                                font-style: italic;
                            }
                        </style>

                        <div id="respond">
                            <?php
                            if (is_user_logged_in()):
                                echo $response;
                                ?>
                                <p>
                                  Al terminar de registrar tus datos cierra tu sesi&oacute;n para terminar de guardar tu informaci&oacute;n.
                                </p>
                                <form action="<?php the_permalink(); ?>" method="post">

                                    <p><label for="tipo_sangre">Tipo de Sangre / Blood Type: <span>*</span>
                                            <br>
                                            <select name="tipo_sangre_fs">
                                                <option value="">No s&eacute;</option>
                                                <?php
                                                //echo esc_attr($_POST['tipo_sangre_fs']);
                                                foreach ($tipo_sangre as $ts) {
                                                    if (esc_attr($_POST['tipo_sangre_fs']) == $ts->id)
                                                        echo '<option selected="selected" value="' . $ts->id . '">' . $ts->nombre . '</option>';
                                                    else
                                                        echo '<option value="' . $ts->id . '">' . $ts->nombre . '</option>';
                                                }
                                                ?>
                                            </select></label></p>
                                    <p><label for="tipo_diabetes">Tipo de diabetes / Diabetes Type: <span>*</span> <br>
                                            <select name="tipo_diabetes_fs">
                                                <?php
                                                foreach ($tipo_diabetes as $ts) {
                                                    if (esc_attr($_POST['tipo_diabetes_fs']) == $ts->id)
                                                        echo '<option selected="selected" value="' . $ts->id . '">' . $ts->nombre . '</option>';
                                                    else
                                                        echo '<option value="' . $ts->id . '">' . $ts->nombre . '</option>';
                                                }
                                                ?>
                                                <?php //echo esc_attr($_POST['tipo_diabetes_fs']); ?>
                                            </select>
                                        </label></p>
                                    <p><label for="presion_sistolica">Presi&oacute;n arterial sist&oacute;lica (Alta) / Systolic Blood Pressure:
                                            <span class="consejo">Segundo par&aacute;metro de presi&oacute;n / Second parameter pressure</span>
                                            <br>
                                            <input type="number" name="presion_sistolica_fs" value="<?php echo esc_attr($_POST['presion_sistolica_fs']); ?>"></label></p>
                                    <p><label for="presion_diastolica">Presi&oacute;n arterial diast&oacute;lica (Baja) / Diastolic Blood Pressure:
                                            <span class="consejo">Primer par&aacute;metro de presi&oacute;n / First parameter pressure</span>
                                            <br>
                                            <input type="number" name="presion_diastolica_fs" value="<?php echo esc_attr($_POST['presion_diastolica_fs']); ?>"></label></p>

                                    <p><label for="donador_organos">Donador de &oacute;rganos / Organ Donor:
                                            <span class="consejo">En caso de muerte /In case of death </span>
                                            <br>
                                            <input type="checkbox" id="donador_organos" name="donador_organos_fs" value="1" <?php echo (($_POST['donador_organos_fs'] == '1') ? 'checked' : ''); ?>>SI</label></p>
                                    <p><label for="servicio_medico">Servicio m&eacute;dico / Healt Insurance:
                                            <span class="consejo">Ex: IMSS / Health Care</span>
                                            <br>
                                            <input type="text" name="servicio_medico_fs" value="<?php echo esc_attr($_POST['servicio_medico_fs']); ?>"></label></p>
                                    <p><label for="numero_poliza">N&uacute;mero de p&oacute;liza / Policy Number:
                                            <br>
                                            <input type="text" name="numero_poliza_fs" value="<?php echo esc_attr($_POST['numero_poliza_fs']); ?>"></label></p>
                                    <p><label for="servicio_medico2">Servicio m&eacute;dico adicional / Healt Insurance 2:
                                            <span class="consejo">Ex: Seguro Popular / Health Care</span>
                                            <br>
                                            <input type="text" name="servicio_medico2_fs" value="<?php echo esc_attr($_POST['servicio_medico2_fs']); ?>"></label></p>
                                    <?php
                                    if ($basicos->sexo == 'F') {
                                        echo'<p><label for="embarazada">Embarazada:  <br><input type="checkbox" id="embarazada" name="embarazada_fs" value="1"' . (($_POST['embarazada_fs'] === 1) ? 'checked' : '') . '>SI</label></p>';
                                    }
                                    ?>
                                    <p><label for="nombre">Alergias / Allergies:
                                            <span class="consejo">Para evitar reacciones al&eacute;gicas de algun tratamiento / To avoid allergic reactions of any treatment</span>
                                            <br>
                                            <textarea name="alergias_fs" ><?php echo esc_attr($_POST['alergias_fs']); ?> </textarea></label></p>
                                    <p><label for="medicamentos">Medicamentos / Drugs :
                                            <span class="consejo">Medicamentos que tome actualmente / Drugs that currently take </span>
                                            <br>
                                            <textarea name="medicamentos_fs"><?php echo esc_attr($_POST['medicamentos_fs']); ?></textarea></label></p>
                                    <p><label for="enfermedades">Enfermedades / Diseases:
                                            <span class="consejo">Cr&oacute;nicas, permanentes o alguna que sea de relevancia mencionar / Chronicles permantes or one that is relevant to mention</span>
                                            <br>
                                            <textarea name="enfermedades_fs"> <?php echo esc_attr($_POST['enfermedades_fs']); ?></textarea></label></p>
                                    <p><label for="cirugias">Cirug&iacute;as / Surgeries:
                                            <span class="consejo">Mencionar cuales / Wich surgieries</span>
                                            <br>
                                            <textarea name="cirugias_fs"> <?php echo esc_attr($_POST['cirugias_fs']); ?></textarea></label></p>
                                    <p><label for="otras_consideraciones">Otras consideraciones / Considerations:
                                            <span class="consejo">Escribir algun detalle relevante no mencionado anteriormente / Write some important detail not mentioned above</span>
                                            <br>
                                            <textarea name="otras_consideraciones_fs"><?php echo esc_attr($_POST['otras_consideraciones_fs']); ?></textarea></label></p>

                                    <h3>Discapacidades y/o dispositivos / Disabilities and / or devices</h3>
                                    <p><span class="consejo">Si no tiene que mencionarlo puede dejarlo en blanco / If you do not have to mention it leave it blank</span></p>
                                    <p><label for="auditiva">Discapacidad auditiva / Hearing Impaired:
                                            <span class="consejo">Especifique si la tiene y en cual o&iacute;do o en ambos / Specify if you have and which ear or both</span>
                                            <br>
                                            <textarea name="auditiva_fs" ><?php echo esc_attr($_POST['auditiva_fs']); ?></textarea></label></p>
                                    <p><label for="mental">Discapacidad mental / Mental disability:
                                            <span class="consejo">Mencione cual o cuales / Wich </span>
                                            <br>
                                            <textarea name="mental_fs" ><?php echo esc_attr($_POST['mental_fs']); ?></textarea></label></p>
                                    <p><label for="motora">Discapacidad motora / Motor disabilities:
                                            <span class="consejo">Especifique cual / specify which</span>
                                            <br>
                                            <textarea name="motora_fs" ><?php echo esc_attr($_POST['motora_fs']); ?></textarea></label></p>
                                    <p><label for="visual">Discapacidad visual / Visual Impairment:
                                            <span class="consejo">Mencione cual enfermedad / which visual condition?</span>
                                            <br>
                                            <textarea name="visual_fs" ><?php echo esc_attr($_POST['visual_fs']); ?></textarea></label></p>
                                    <p><label for="marcapasos">Dispositivo de soporte vital marcapasos / Life support device:
                                            <span class="consejo">Mencione si tiene y desde cuando / If you have one,since when?</span>
                                            <br>
                                            <textarea name="marcapasos_fs" ><?php echo esc_attr($_POST['marcapasos_fs']); ?></textarea></label></p>
                                    <p><label for="lentes_contacto">Lentes de contacto / Contact Lenses:
                                            <span class="consejo">Especifique si usa regularmente / Specify if you use it regularly </span>
                                            <br>
                                            <textarea name="lentes_contacto_fs" ><?php echo esc_attr($_POST['lentes_contacto_fs']); ?></textarea></label></p>
                                    <p><label for="protesis_dentales">P&oacute;tesis dentales / Dental Denture:
                                            <span class="consejo">Desde placa completa dental o algun diente / from one tooth to a complete dental plaque</span>
                                            <br>
                                            <textarea name="protesis_dentales_fs" ><?php echo esc_attr($_POST['protesis_dentales_fs']); ?></textarea></label></p>
                                    <p><label for="protesis_oculares">P&oacute;tesis oculares / Ocular Prosthesis:
                                            <span class="consejo">Mencione cual ojo/ Wich Eye?</span>
                                            <br>
                                            <textarea name="protesis_oculares_fs" ><?php echo esc_attr($_POST['protesis_oculares_fs']); ?></textarea></label></p>
                                    <p><label for="med_naturales">Medicamentos de origen natural / Drugs of natural origin:
                                            <span class="consejo">Tambi&eacute;n incluye herbolaria / Like herbology</span>
                                            <br>
                                            <textarea name="med_naturales_fs" ><?php echo esc_attr($_POST['med_naturales_fs']); ?></textarea></label></p>
                                    <p><label for="vacunas">Vacunas aplicadas / Vaccines:
                                            <span class="consejo">Mencione cuales y en que fecha aproximadamente / mentions vaccines and approximate dates</span>
                                            <br>
                                            <textarea name="vacunas_fs" ><?php echo esc_attr($_POST['vacunas_fs']); ?></textarea></label></p>
                                    <!--<p><label for="message_human">Verificaci&oacute;n:  <br><input type="text" style="width: 60px;" name="message_human"> + 3 = 5</label></p>-->

                                                                                                <!--                  <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" value="<?php // echo esc_attr($_POST['message_name']);             ?>"></label></p>
                                                                                                <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" value="<?php //echo esc_attr($_POST['message_email']);             ?>"></label></p>
                                                                                                <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" name="message_text"><?php //echo esc_textarea($_POST['message_text']);             ?></textarea></label></p>
                                    -->
                                    <input type="hidden" name="submitted" value="1">
                                    <p><input type="submit" value="Guardar y continuar"></p>
                                </form>
                            </div>


                        </div><!-- .entry-content -->
                <?php endif; // end of the loop.      ?>
                </article><!-- #post -->

        <?php endwhile; // end of the loop.      ?>

        </div><!-- #content -->
        <?php
        $avia_config['size'] = avia_layout_class('main', false) == 'entry_without_sidebar' ? '' : 'entry_with_sidebar';

        get_sidebar();
        ?>
    </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

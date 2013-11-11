<?php
/*
 * Template Name: Datos basicos
 */
global $avia_config;
$mes = array("01" => 'Enero', "02" => 'Febrero', "03" => 'Marzo', "04" => 'Abril', "05" => 'Mayo', "06" => 'Junio', "07" => 'Julio', "08" => 'Agosto', "09" => 'Septiembre', "10" => 'Octubre', "11" => 'Noviembre', "12" => 'Diciembre');

//response generation function

$response = "";
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
    }
}

//function to generate response
function my_contact_form_generate_response($type, $message) {
    global $response;
    $url_redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/datos-medicos/';
    if ($type == "success") {
        $response = "<div class='success'>{$message}
        <a href='{$url_redirect}'>Para continuar con tu registro haz click aqui</a>    
        </div>";
    }else
        $response = "<div class='error'>{$message}</div>";
}

//response messages
//$not_human = "Human verification incorrect.";
//$missing_content = "Please supply all information.";
//$email_invalid = "Email Address Invalid.";
//$message_unsent = "Message was not sent. Try Again.";
//$message_sent = "Thanks! Your message has been sent.";
$mensaje = array(
    'nohumano' => 'Favor de llenar la suma',
    'nocorreo' => 'El correo es invalido',
    'nombre' => 'Nombre está vacio',
    'paterno' => 'Apellido paterno está vacio',
    'peso' => 'El peso está vacio',
    'estatura' => 'La estatura está vacia',
    'fechanac' => 'La fecha de nacimiento es invalida',
    'guardado' => 'Fue guardado con exito',
    'noguardado' => 'No se pudo guardar',
);

////user posted variables
//$name = $_POST['message_name'];
//$email = $_POST['message_email'];
//$message = $_POST['message_text'];
//$human = $_POST['message_human'];
//php mailer variables
//$to = get_option('admin_email');
//$subject = "Someone sent a message from " . get_bloginfo('name');
//$headers = 'From: ' . $email . "\r\n" .
//        'Reply-To: ' . $email . "\r\n";

$current_user = wp_get_current_user();
$q_user = 'select * from ' . $wpdb->prefix . 'datos_basicos where ' . $wpdb->prefix . 'users_id = ' . $current_user->ID;
$user = $wpdb->get_row($q_user, OBJECT);
//if (!$human == 0) {
//    if ($human != 2)
//        my_contact_form_generate_response("error", $mensaje['nohumano']); //not human!
//    else {
//validate email
//        if (!filter_var($_POST['correo_emergencia_fs'], FILTER_VALIDATE_EMAIL))
//            my_contact_form_generate_response("error", $mensaje['nocorreo']);
//        else { //email is valid
//validate presence of name and message
if (!empty($_POST['submitted'])) {
    if (empty($_POST['nombre_fs'])) {
        my_contact_form_generate_response("error", $mensaje['nombre']);
    } else  //ready to go!
//            if (empty($_POST['peso_fs'])) {
//                my_contact_form_generate_response("error", $mensaje['peso']);
//            } else  //ready to go!
//            if (empty($_POST['estatura_fs'])) {
//                my_contact_form_generate_response("error", $mensaje['estatura']);
//            } else  //ready to go!
//            if (empty($_POST['dia_fs']) && empty($_POST['mes_fs']) && empty($_POST['anio_fs'])) {
//                my_contact_form_generate_response("error", $mensaje['estatura']);
//            } else  //ready to go!
    if (empty($_POST['ap_paterno_fs'])) {
        my_contact_form_generate_response("error", $mensaje['paterno']);
    } else { //VALIDACION COMPLETA, SIGUE LA INSERCION O ACTUALIZACION
        $fecha = $_POST['anio_fs'] . '-' . $_POST['mes_fs'] . '-' . $_POST['dia_fs'];
        if (empty($user)) {

            if ($wpdb->insert(
                            $wpdb->prefix . 'datos_basicos', array(
                        'wp_users_id' => mysql_real_escape_string($current_user->ID),
                        'nombre' => mysql_real_escape_string($_POST['nombre_fs']),
                        'ap_paterno' => mysql_real_escape_string($_POST['ap_paterno_fs']),
                        'ap_materno' => mysql_real_escape_string($_POST['ap_materno_fs']),
                        'encargado_emergencia' => mysql_real_escape_string($_POST['nom_emergencia_fs']),
                        'tel_emergencia' => mysql_real_escape_string($_POST['tel_emergencia_fs']),
                        'correo_emergencia' => mysql_real_escape_string($_POST['correo_emergencia_fs']),
                        'nom_medico' => mysql_real_escape_string($_POST['nom_medico_fs']),
                        'tel_medico' => mysql_real_escape_string($_POST['tel_medico_fs']),
                        'fecha_nac' => $fecha,
                        'peso' => mysql_real_escape_string($_POST['peso_fs']),
                        'estatura' => mysql_real_escape_string($_POST['estatura_fs']),
                        'sexo' => mysql_real_escape_string($_POST['sexo_fs'])
                            )
                    ) == FALSE) {
                my_contact_form_generate_response("error", $mensaje['noguardado']);
            } else {
                my_contact_form_generate_response("success", $mensaje['guardado']);
            }
        } else {
            if ($wpdb->update(
                            $wpdb->prefix . 'datos_basicos', array(
                        'wp_users_id' => mysql_real_escape_string($current_user->ID),
                        'nombre' => mysql_real_escape_string($_POST['nombre_fs']),
                        'ap_paterno' => mysql_real_escape_string($_POST['ap_paterno_fs']),
                        'ap_materno' => mysql_real_escape_string($_POST['ap_materno_fs']),
                        'encargado_emergencia' => mysql_real_escape_string($_POST['nom_emergencia_fs']),
                        'tel_emergencia' => mysql_real_escape_string($_POST['tel_emergencia_fs']),
                        'correo_emergencia' => mysql_real_escape_string($_POST['correo_emergencia_fs']),
                        'nom_medico' => mysql_real_escape_string($_POST['nom_medico_fs']),
                        'tel_medico' => mysql_real_escape_string($_POST['tel_medico_fs']),
                        'fecha_nac' => $fecha,
                        'peso' => mysql_real_escape_string($_POST['peso_fs']),
                        'estatura' => mysql_real_escape_string($_POST['estatura_fs']),
                        'sexo' => mysql_real_escape_string($_POST['sexo_fs'])
                            ), array('wp_users_id' => mysql_real_escape_string($current_user->ID))
                    ) == FALSE)
                my_contact_form_generate_response("error", $mensaje['noguardado']);
            else
                my_contact_form_generate_response("success", $mensaje['guardado']);
        }
//            }
//                $sent = wp_mail($to, $subject, strip_tags($message), $headers);
//                if ($sent)
//                    my_contact_form_generate_response("success", $message_sent); //message sent!
//                else
//                    my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
    }
}
//} else if ($_POST['submitted'])
//    my_contact_form_generate_response("error", $missing_content);


if (!empty($user)) {
    $_POST['nombre_fs'] = $user->nombre;
    $_POST['ap_paterno_fs'] = $user->ap_paterno;
    $_POST['ap_materno_fs'] = $user->ap_materno;
    $_POST['nom_emergencia_fs'] = $user->encargado_emergencia;
    $_POST['tel_emergencia_fs'] = $user->tel_emergencia;
    $_POST['correo_emergencia_fs'] = $user->correo_emergencia;
    $_POST['nom_medico_fs'] = $user->nom_medico;
    $_POST['tel_medico_fs'] = $user->tel_medico;
//$_POST['$fecha'] = $user->fecha_nac;
    $_POST['peso_fs'] = $user->peso;
    $_POST['estatura_fs'] = $user->estatura;
    $_POST['sexo_fs'] = $user->sexo;

    $fecha_c = explode('-', $user->fecha_nac);
    $_POST['dia_fs'] = $fecha_c[2];
    $_POST['mes_fs'] = $fecha_c[1];
    $_POST['anio_fs'] = $fecha_c[0];
}
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
                        </style>

                        <div id="respond">
                            <?php
                            if (is_user_logged_in()):
                                echo $response;
                                ?>
                                <form action="<?php the_permalink(); ?>" method="post">
                                    <!--<h3>Datos b&aacute;sicos</h3>-->
                                    <p><label for="nombre">Nombre: <span>*</span> <br>
                                            <input type="text" required="required" name="nombre_fs" value="<?php echo esc_attr($_POST['nombre_fs']); ?>"></label></p>
                                    <p><label for="ap_paterno">Apellido paterno: <span>*</span> <br>
                                            <input type="text" required="required" name="ap_paterno_fs" value="<?php echo esc_attr($_POST['ap_paterno_fs']); ?>"></label></p>
                                    <p><label for="ap_materno">Apellido materno:  <br>
                                            <input type="text" name="ap_materno_fs" value="<?php echo esc_attr($_POST['ap_materno_fs']); ?>"></label></p>
                                    <p><label for="nom_emergencia">Nombre del encargado de emergencia:  <br>
                                            <input type="text" name="nom_emergencia_fs" value="<?php echo esc_attr($_POST['nom_emergencia_fs']); ?>"></label></p>
                                    <p><label for="tel_emergencia">Tel&eacute;fono de emergencia:  <br>
                                            <input type="text" name="tel_emergencia_fs" value="<?php echo esc_attr($_POST['tel_emergencia_fs']); ?>"></label></p>
                                    <p><label for="correo_emergencia">Correo de emergencia:  <br>
                                            <input type="email" name="correo_emergencia_fs" value="<?php echo esc_attr($_POST['correo_emergencia_fs']); ?>"></label></p>
                                    <p><label for="nom_medico">Nombre del m&eacute;dico:  <br>
                                            <input type="text" name="nom_medico_fs" value="<?php echo esc_attr($_POST['nom_medico_fs']); ?>"></label></p>
                                    <p><label for="tel_medico">Tel&eacute;fono del m&eacute;dico:  <br>
                                            <input type="text" name="tel_medico_fs" value="<?php echo esc_attr($_POST['tel_medico_fs']); ?>"></label></p>
                                    <p><label for="edad">Fecha de nacimiento:  <br>
                                            <label for="dia">D&iacute;a</label>
                                            <select id="dia" name="dia_fs" >
                                                <option value="null">--</option>
                                                <?php
                                                for ($j = 1; $j <= 31; $j++) {
                                                    if (strlen($j) == 1)
                                                        $jz = '0' . $j;
                                                    else
                                                        $jz = $j;
                                                    if (esc_attr($_POST['dia_fs']) == $jz)
                                                        echo'<option value="' . $jz . '" selected="selected">' . $jz . '</option>';
                                                    else
                                                        echo'<option value="' . $jz . '">' . $jz . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <label for="mes">Mes</label>
                                            <select id="mes" name="mes_fs" >
                                                <option value="null">----------</option>
                                                <?php
                                                foreach ($mes as $k => $m) {
                                                    if (esc_attr($_POST['mes_fs']) == $k) {
                                                        echo'<option value="' . $k . '" selected="selected">' . $m . '</option>';
                                                    } else {
                                                        echo'<option value="' . $k . '">' . $m . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <label for="anio">A&ntilde;o</label>
                                            <select id="anio" name="anio_fs" >
                                                <?php
                                                for ($j = date('Y'); $j >= 1900; $j--) {
                                                    if (esc_attr($_POST['anio_fs']) == $j)
                                                        echo'<option value="' . $j . '" selected="selected">' . $j . '</option>';
                                                    else
                                                        echo'<option value="' . $j . '">' . $j . '</option>';
                                                }

//                                        echo esc_attr($_POST['mes_fs']); 
                                                ?>
                                            </select>
                                            <p><label for="peso">Peso en Kilogramos: <br>
                                                    <input type="text" size="5" name="peso_fs" value="<?php echo esc_attr($_POST['peso_fs']); ?>"></label></p>
                                            <p><label for="estatura">Estatura en Metros:  <br>
                                                    <input type="text" size="5" name="estatura_fs" value="<?php echo esc_attr($_POST['estatura_fs']); ?>"></label></p>
                                            <p class="one-line"><label for="sexo">Sexo: </label> <br>
                                                <input type="radio" name="sexo_fs" id="sexo_m" value="M" <?php
                                        if ($_POST['sexo_fs'] == 'M') {
                                            echo 'checked';
                                        }
                                                ?>><label for="sexo_m">Masculino</label>
                                                <input type="radio" name="sexo_fs" id="sexo_f" value="F" <?php
                                               if ($_POST['sexo_fs'] == 'F') {
                                                   echo 'checked';
                                               }
                                                ?>><label for="sexo_f">Femenino</label></p>
                                            <!--<p><label for="message_human">Verificaci&oacute;n: <span>*</span> <br><input type="text" required="required" style="width: 60px;" name="message_human"> + 3 = 5</label></p>-->      

                                                            <!--                  <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" value="<?php // echo esc_attr($_POST['message_name']);            ?>"></label></p>
                                                            <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" value="<?php //echo esc_attr($_POST['message_email']);            ?>"></label></p>
                                                            <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" name="message_text"><?php //echo esc_textarea($_POST['message_text']);            ?></textarea></label></p>
                                            -->
                                            <input type="hidden" name="submitted" value="1">
                                            <p><input type="submit" value="Guardar y continuar"></p>
                                </form>
                            </div>


                        </div><!-- .entry-content -->
                    <?php endif; // end of the loop.       ?>
                </article><!-- #post -->

            <?php endwhile; // end of the loop.       ?>

        </div><!-- #content -->
        <?php
        //get the sidebar
        $avia_config['currently_viewing'] = 'page';

        get_sidebar();
        ?>
    </div><!-- #primary -->


    <?php get_footer(); ?>
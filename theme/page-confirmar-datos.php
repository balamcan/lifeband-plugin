<?php
/*
 * Template Name: Datos basicos
 */

//response generation function

$response = "";

//function to generate response
//function my_contact_form_generate_response($type, $message) {
//
//    global $response;
//
//    if ($type == "success")
//        $response = "<div class='success'>{$message}</div>";
//    else
//        $response = "<div class='error'>{$message}</div>";
//}

//response messages
//$not_human = "Human verification incorrect.";
//$missing_content = "Please supply all information.";
//$email_invalid = "Email Address Invalid.";
//$message_unsent = "Message was not sent. Try Again.";
//$message_sent = "Thanks! Your message has been sent.";
//$mensaje = array(
//    'nohumano' => 'Favor de llenar la suma',
//    'nocorreo' => 'El correo es invalido',
//    'nombre' => 'Nombre está vacio',
//    'paterno' => 'Apellido paterno está vacio',
//    'peso' => 'El peso está vacio',
//    'estatura' => 'La estatura está vacia',
//    'fechanac' => 'La fecha de nacimiento es invalida',
//    'guardado' => 'Fue guardado con exito',
//    'noguardado' => 'No se pudo guardar',
//);

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

//$current_user = wp_get_current_user();
//$q_user = 'select * from ' . $wpdb->prefix . 'datos_basicos where ' . $wpdb->prefix . 'users_id = ' . $current_user->ID;
//$user = $wpdb->get_row($q_user, OBJECT);
//var_dump($user);
//if (empty($_POST['submitted']) && !empty($user)) {
//    $_POST['nombre_fs'] = $user->nombre;
//    $_POST['ap_paterno_fs'] = $user->ap_paterno;
//    $_POST['ap_materno_fs'] = $user->ap_materno;
//    $_POST['nom_emergencia_fs'] = $user->encargado_emergencia;
//    $_POST['tel_emergencia_fs'] = $user->tel_emergencia;
//    $_POST['correo_emergencia_fs'] = $user->correo_emergencia;
//    $_POST['nom_medico_fs'] = $user->nom_medico;
//    $_POST['tel_medico_fs'] = $user->tel_medico;
////$_POST['$fecha'] = $user->fecha_nac;
//    $_POST['peso_fs'] = $user->peso;
//    $_POST['estatura_fs'] = $user->estatura;
//    $_POST['sexo_fs'] = $user->sexo;
//
//    $fecha_c = explode('-', $user->fecha_nac);
//    $_POST['dia_fs'] = $fecha_c[2];
//    $_POST['mes_fs'] = $fecha_c[1];
//    $_POST['anio_fs'] = $fecha_c[0];
//}
//if (!$human == 0) {
//    if ($human != 2)
//        my_contact_form_generate_response("error", $mensaje['nohumano']); //not human!
//    else {
//
//        //validate email
//        if (!filter_var($_POST['correo_emergencia_fs'], FILTER_VALIDATE_EMAIL))
//            my_contact_form_generate_response("error", $mensaje['nocorreo']);
//        else { //email is valid
//            //validate presence of name and message
//            if (empty($_POST['nombre_fs'])) {
//                my_contact_form_generate_response("error", $mensaje['nombre']);
//            } else  //ready to go!
//            if (empty($_POST['peso_fs'])) {
//                my_contact_form_generate_response("error", $mensaje['peso']);
//            } else  //ready to go!
//            if (empty($_POST['estatura_fs'])) {
//                my_contact_form_generate_response("error", $mensaje['estatura']);
//            } else  //ready to go!
//            if (empty($_POST['dia_fs']) && empty($_POST['mes_fs']) && empty($_POST['anio_fs'])) {
//                my_contact_form_generate_response("error", $mensaje['estatura']);
//            } else  //ready to go!
//            if (empty($_POST['ap_paterno_fs'])) {
//                my_contact_form_generate_response("error", $mensaje['paterno']);
//            } else { //VALIDACION COMPLETA, SIGUE LA INSERCION O ACTUALIZACION
//                $fecha = $_POST['anio_fs'] . '-' . $_POST['mes_fs'] . '-' . $_POST['dia_fs'];
//                if (empty($user)) {
//
//                    if ($wpdb->insert(
//                                    $wpdb->prefix . 'datos_basicos', array(
//                                'wp_users_id' => mysql_real_escape_string($current_user->ID),
//                                'nombre' => mysql_real_escape_string($_POST['nombre_fs']),
//                                'ap_paterno' => mysql_real_escape_string($_POST['ap_paterno_fs']),
//                                'ap_materno' => mysql_real_escape_string($_POST['ap_materno_fs']),
//                                'encargado_emergencia' => mysql_real_escape_string($_POST['nom_emergencia_fs']),
//                                'tel_emergencia' => mysql_real_escape_string($_POST['tel_emergencia_fs']),
//                                'correo_emergencia' => mysql_real_escape_string($_POST['correo_emergencia_fs']),
//                                'nom_medico' => mysql_real_escape_string($_POST['nom_medico_fs']),
//                                'tel_medico' => mysql_real_escape_string($_POST['tel_medico_fs']),
//                                'fecha_nac' => $fecha,
//                                'peso' => mysql_real_escape_string($_POST['peso_fs']),
//                                'estatura' => mysql_real_escape_string($_POST['estatura_fs']),
//                                'sexo' => mysql_real_escape_string($_POST['sexo_fs'])
//                                    )
//                            ) == FALSE) {
//                        my_contact_form_generate_response("error", $mensaje['noguardado']);
//                    } else {
//                        my_contact_form_generate_response("success", $mensaje['guardado']);
//                    }
//                } else {
//                    if ($wpdb->update(
//                                    $wpdb->prefix . 'datos_basicos', array(
//                                'wp_users_id' => mysql_real_escape_string($current_user->ID),
//                                'nombre' => mysql_real_escape_string($_POST['nombre_fs']),
//                                'ap_paterno' => mysql_real_escape_string($_POST['ap_paterno_fs']),
//                                'ap_materno' => mysql_real_escape_string($_POST['ap_materno_fs']),
//                                'encargado_emergencia' => mysql_real_escape_string($_POST['nom_emergencia_fs']),
//                                'tel_emergencia' => mysql_real_escape_string($_POST['tel_emergencia_fs']),
//                                'correo_emergencia' => mysql_real_escape_string($_POST['correo_emergencia_fs']),
//                                'nom_medico' => mysql_real_escape_string($_POST['nom_medico_fs']),
//                                'tel_medico' => mysql_real_escape_string($_POST['tel_medico_fs']),
//                                'fecha_nac' => $fecha,
//                                'peso' => mysql_real_escape_string($_POST['peso_fs']),
//                                'estatura' => mysql_real_escape_string($_POST['estatura_fs']),
//                                'sexo' => mysql_real_escape_string($_POST['sexo_fs'])
//                                    ), array('wp_users_id' => mysql_real_escape_string($current_user->ID))
//                            ) == FALSE)
//                        my_contact_form_generate_response("error", $mensaje['noguardado']);
//                    else
//                        my_contact_form_generate_response("success", $mensaje['guardado']);
//                }
//            }
//
////                $sent = wp_mail($to, $subject, strip_tags($message), $headers);
////                if ($sent)
////                    my_contact_form_generate_response("success", $message_sent); //message sent!
////                else
////                    my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
//        }
//    }
//} else if ($_POST['submitted'])
//    my_contact_form_generate_response("error", $missing_content);
//?>

<?php get_header(); ?>

<div id="primary" class="site-content">
    <div id="content" role="main">

<?php while (have_posts()) : the_post(); ?>

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

                        form span{
                            color: red;
                        }
                        #respond form .one-line label, #respond form .one-line input{
                            display: inline-block;
                        }
                    </style>

                    <div id="respond">
    <?php
//                if (is_user_logged_in()):
    echo $response;
    ?>
                        <form action="<?php the_permalink(); ?>" method="post">
                            <!--<h3>Datos b&aacute;sicos</h3>-->
                            <p><label for="contrasena">Contraseña: <span>*</span> <br>
                                    <input type="text" required="required" name="contrasena_fs" value="<?php echo esc_attr($_POST['contrasena_fs']); ?>"></label></p>
                            <p><label for="n_contrasena">Nueva contraseña: <span>*</span> <br>
                                    <input type="text" required="required" name="n_contrasena_fs" value="<?php echo esc_attr($_POST['n_contrasena_fs']); ?>"></label></p>
                            <p><label for="confirm">Confirmar contraseña: <span>*</span> <br>
                                    <input type="text" required="required" name="confirm_fs" value="<?php echo esc_attr($_POST['confirm_fs']); ?>"></label></p>
                            <p><label for="correo">Correo: <span>*</span> <br>
                                    <input type="email" required="required" name="correo_fs" value="<?php echo esc_attr($_POST['correo_fs']); ?>"></label></p>
                                     <p><label for="message_human">Verificaci&oacute;n: <span>*</span> <br><input type="text" required="required" style="width: 60px;" name="message_human"> + 6 = 8</label></p>      

                            <!--                  <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" value="<?php // echo esc_attr($_POST['message_name']);        ?>"></label></p>
                            <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" value="<?php //echo esc_attr($_POST['message_email']);        ?>"></label></p>
                            <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" name="message_text"><?php //echo esc_textarea($_POST['message_text']);        ?></textarea></label></p>
                                    -->
                                    <input type="hidden" name="submitted" value="1">
                                    <p><input type="submit" value="Guardar y continuar"></p>
                        </form>
                    </div>


                </div><!-- .entry-content -->
    <?php //endif; // end of the loop.      ?>
            </article><!-- #post -->

<?php endwhile; // end of the loop.      ?>

    </div><!-- #content -->
</div><!-- #primary -->

        <?php get_sidebar(); ?>
<?php get_footer(); ?>
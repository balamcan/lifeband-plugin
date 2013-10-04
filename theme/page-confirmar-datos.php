<?php
/*
 * Template Name: Datos basicos
 */

//response generation function

$response = "";

//function to generate response
function my_contact_form_generate_response($type, $message) {

    global $response;

    if ($type == "success")
        $response = "<div class='success'>{$message}</div>";
    else
        $response = "<div class='error'>{$message}</div>";
}

//response messages
$not_human = "Favor de realizar la suma.";
//$missing_content = "Please supply all information.";
$email_invalid = "Correo invalido.";
$message_unsent = "Error al guardar los datos, favor de intentarlo de nuevo.";
$message_sent = "¡¡¡Gracias!!! Tus datos han sido guardados satisfactoriamente.";
$pass_invalid = "Contrase&ntilde;a invalida.";
$confirm_invalid = "No coincide la nueva contrase&ntilde;a con la confirmaci&oacute;n.";
//user posted variables
$old = $_POST['contrasena_fs'];
$email = $_POST['correo_fs'];
$new = $_POST['n_contrasena_fs'];
$confirm = $_POST['confirm_fs'];
$human = $_POST['message_human'];

////php mailer variables
//$to = get_option('admin_email');
//$subject = "Someone sent a message from " . get_bloginfo('name');
//$headers = 'From: ' . $email . "\r\n" .
//        'Reply-To: ' . $email . "\r\n";
$current_user = wp_get_current_user();

if (!$human == 0) {
    if ($human != 2)
        my_contact_form_generate_response("error", $not_human); //not human!
    else {

        //validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            my_contact_form_generate_response("error", $email_invalid);
        else { //email is valid
            $userdata = get_user_by('login', $current_user->user_login);
            $result = wp_check_password($old, $userdata->user_pass, $userdata->ID);
            //validate presence of name and message
            if (!$result) {
                my_contact_form_generate_response("error", $pass_invalid);
            } else { //ready to go!
                if ($new !== $confirm) {
                    my_contact_form_generate_response("error", $confirm_invalid);
                } else { //ready to go!
                    //wp_set_password( $new, $current_user->ID );
                    $complete=wp_update_user(
                            array('ID' => $current_user->ID,
                                'user_email' => $email,
                                'user_pass' => $new
                            )
                    );
                    
                    //$sent = wp_mail($to, $subject, strip_tags($message), $headers);
                    
                    if ($complete){
                        //se AGREGA UN META USUARIO PARA IDENTIFICAR SI CAMBIO LA CONTRASEÑA Y CORREO
                        if( get_user_meta($current_user->ID, 'wp_human_user'))// con esta condicional sabes si existe el user meta
                            update_user_meta($current_user->ID, 'wp_human_user', true);
                        else
                            add_user_meta($current_user->ID, 'wp_human_user', true);
                        
                        my_contact_form_generate_response("success", $message_sent); //message sent!
                    }else
                        my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
                }
            }
        }
    }
}
//else if ($_POST['submitted'])
//    my_contact_form_generate_response("error", $missing_content);
?>

<?php get_header(); ?>

<div id="primary" class="site-content">
    <div id="content" role="main">

<?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title();
    echo ' - ' . $current_user->user_login;    ?> </h1>
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
                if (is_user_logged_in()):
    echo $response;
    ?>
                            <form action="<?php the_permalink(); ?>" method="post">
                            <!--<h3>Datos b&aacute;sicos</h3>-->
                            <p><label for="contrasena">Contraseña: <span>*</span> <br>
                                    <input type="password" required="required" name="contrasena_fs" value="<?php //echo esc_attr($_POST['contrasena_fs']); ?>"></label></p>
                            <p><label for="n_contrasena">Nueva contraseña: <span>*</span> <br>
                                    <input type="password" required="required" name="n_contrasena_fs" value="<?php //echo esc_attr($_POST['n_contrasena_fs']); ?>"></label></p>
                            <p><label for="confirm">Confirmar contraseña: <span>*</span> <br>
                                    <input type="password" required="required" name="confirm_fs" value="<?php //echo esc_attr($_POST['confirm_fs']); ?>"></label></p>
                            <p><label for="correo">Correo: <span>*</span> <br>
                                    <input type="email" required="required" name="correo_fs" value="<?php echo esc_attr($_POST['correo_fs']); ?>"></label></p>
                            <p><label for="message_human">Verificaci&oacute;n: <span>*</span> <br><input type="text" required="required" style="width: 60px;" name="message_human"> + 6 = 8</label></p>      

                                    <!--                  <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" value="<?php // echo esc_attr($_POST['message_name']);          ?>"></label></p>
                                    <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" value="<?php //echo esc_attr($_POST['message_email']);          ?>"></label></p>
                                    <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" name="message_text"><?php //echo esc_textarea($_POST['message_text']);          ?></textarea></label></p>
                            -->
                            <input type="hidden" name="submitted" value="1">
                            <p><input type="submit" value="Guardar y continuar"></p>
                        </form>
                    </div>


                </div><!-- .entry-content -->
    <?php endif; // end of the loop.        ?>
            </article><!-- #post -->

<?php endwhile; // end of the loop.        ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
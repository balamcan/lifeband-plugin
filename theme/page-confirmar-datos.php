<?php
/*
 * Template Name: Datos basicos
 */
global $avia_config;

$current_user = wp_get_current_user();
$human_user = get_user_meta($current_user->ID, 'wp_human_user');

//if ($current_user->user_level == 0) {
if ($human_user[0] == '1' && $_GET['hash'] !== "540f6f564efghahk") {// con esta condicional sabes si existe el user meta
    wp_redirect('http://' . $_SERVER['HTTP_HOST'] . '/datos-basicos/');
    exit;
}
//}
//response generation function
//    global $wpdb;
//retrieve current user info 
//    global $current_user;
//    get_currentuserinfo();
//If login user role is Subscriber




$response = "";

//        wp_redirect('http://'.$_SERVER['HTTP_HOST'].'/datos-basicos/');
//function to generate response
function my_contact_form_generate_response($type, $message) {
    global $response;
    $url_redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/datos-basicos/';
    if ($type == "success") {
        $response = "<div class='success'>{$message}
        <a href='{$url_redirect}'>Para continuar con tu registro haz click aqui</a>    
        </div>";
    }else
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
//if (!$human == 0) {
//    if ($human != 2)
//        my_contact_form_generate_response("error", $not_human); //not human!
//    else {
//validate email
if (!empty($_POST['submitted'])) {
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
                $complete = wp_update_user(
                        array('ID' => $current_user->ID,
                            'user_email' => $email,
                            'user_pass' => $new
                        )
                );

                //$sent = wp_mail($to, $subject, strip_tags($message), $headers);

                if ($complete) {
                    //se AGREGA UN META USUARIO PARA IDENTIFICAR SI CAMBIO LA CONTRASEÑA Y CORREO
                    if (get_user_meta($current_user->ID, 'wp_human_user'))// con esta condicional sabes si existe el user meta
                        update_user_meta($current_user->ID, 'wp_human_user', true);
                    else
                        add_user_meta($current_user->ID, 'wp_human_user', true);

                    my_contact_form_generate_response("success", $message_sent); //message sent!
                }else
                    my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
            }
        }
    }
//    }
}
//else if ($_POST['submitted'])
//    my_contact_form_generate_response("error", $missing_content);
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
                        <h1 class="entry-title"><?php
            the_title();
            echo ' - ' . $current_user->user_login;
                ?> </h1>
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
                                    <p><label for="contrasena">Contraseña: <span>*</span> <br>
                                            <input type="password" required="required" name="contrasena_fs" value="<?php //echo esc_attr($_POST['contrasena_fs']);     ?>"></label></p>
                                    <p><label for="n_contrasena">Nueva contraseña: <span>*</span> <br>
                                            <input type="password" required="required" name="n_contrasena_fs" value="<?php //echo esc_attr($_POST['n_contrasena_fs']);     ?>"></label></p>
                                    <p><label for="confirm">Confirmar contraseña: <span>*</span> <br>
                                            <input type="password" required="required" name="confirm_fs" value="<?php //echo esc_attr($_POST['confirm_fs']);     ?>"></label></p>
                                    <p><label for="correo">Correo: <span>*</span> <br>
                                            <input type="email" required="required" name="correo_fs" value="<?php echo esc_attr($_POST['correo_fs']); ?>"></label></p>
                                    <!--<p><label for="message_human">Verificaci&oacute;n: <span>*</span> <br><input type="text" required="required" style="width: 60px;" name="message_human"> + 6 = 8</label></p>-->      

                                                                    <!--                  <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" value="<?php // echo esc_attr($_POST['message_name']);              ?>"></label></p>
                                                                    <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" value="<?php //echo esc_attr($_POST['message_email']);              ?>"></label></p>
                                                                    <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" name="message_text"><?php //echo esc_textarea($_POST['message_text']);              ?></textarea></label></p>
                                    -->
                                    <input type="hidden" name="submitted" value="1">
                                    <p><input type="submit" value="Guardar y continuar"></p>
                                </form>
                            </div>


                        </div><!-- .entry-content -->
                    <?php endif; // end of the loop.         ?>
                </article><!-- #post -->

            <?php endwhile; // end of the loop.         ?>

        </div><!-- #content -->
        <?php
        $avia_config['currently_viewing'] = 'page';
        get_sidebar();
        ?>
    </div><!-- #primary -->


    <?php get_footer(); ?>
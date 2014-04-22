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
        <a href='{$url_redirect}'>Para continuar con tu registro haz click aqui / to continue with your register click here</a>    
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
    'nohumano' => 'Favor de llenar la suma / Please complete the sum',
    'nocorreo' => 'El correo es invalido / invalid e-mail',
    'nombre' => 'Nombre está vacio / the name is empty',
    'paterno' => 'Apellido paterno está vacio / Last name is empty',
    'peso' => 'El peso está vacio / Please fill your weight',
    'estatura' => 'La estatura está vacia / Please fill your height',
    'fechanac' => 'La fecha de nacimiento es invalida / your birthday is invalid',
    'guardado' => 'Fue guardado con exito / successfully saved',
    'noguardado' => 'No se pudo guardar / It could not be saved ',
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
if(isset($user->foto)){
    $fotosrc='http://lifeband.com.mx/fotos/'.$user->foto;
}
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
                        'encargado_emergencia2' => mysql_real_escape_string($_POST['nom_emergencia2_fs']),
                        'encargado_emergencia3' => mysql_real_escape_string($_POST['nom_emergencia3_fs']),
                        'tel_emergencia' => mysql_real_escape_string($_POST['tel_emergencia_fs']),
                        'tel_emergencia2' => mysql_real_escape_string($_POST['tel_emergencia2_fs']),
                        'tel_emergencia3' => mysql_real_escape_string($_POST['tel_emergencia3_fs']),
                        'correo_emergencia' => mysql_real_escape_string($_POST['correo_emergencia_fs']),
                        'nom_medico' => mysql_real_escape_string($_POST['nom_medico_fs']),
                        'tel_medico' => mysql_real_escape_string($_POST['tel_medico_fs']),
                        'nom_medico2' => mysql_real_escape_string($_POST['nom_medico2_fs']),
                        'tel_medico2' => mysql_real_escape_string($_POST['tel_medico2_fs']),
                        'nom_medico3' => mysql_real_escape_string($_POST['nom_medico3_fs']),
                        'tel_medico3' => mysql_real_escape_string($_POST['tel_medico3_fs']),
                        'no_pasaporte' => mysql_real_escape_string($_POST['pasaporte_fs']),
                        'fecha_nac' => $fecha,
                        'peso' => mysql_real_escape_string($_POST['peso_fs']),
                        'estatura' => mysql_real_escape_string($_POST['estatura_fs']),
                        'sexo' => mysql_real_escape_string($_POST['sexo_fs']),
                        'foto' => mysql_real_escape_string($_POST['foto_fs'])
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
                        'encargado_emergencia2' => mysql_real_escape_string($_POST['nom_emergencia2_fs']),
                        'tel_emergencia2' => mysql_real_escape_string($_POST['tel_emergencia2_fs']),
                        'encargado_emergencia3' => mysql_real_escape_string($_POST['nom_emergencia3_fs']),
                        'tel_emergencia3' => mysql_real_escape_string($_POST['tel_emergencia3_fs']),
                        'correo_emergencia' => mysql_real_escape_string($_POST['correo_emergencia_fs']),
                        'numero_celular' => mysql_real_escape_string($_POST['correo_emergencia_fs']),
                        'nom_medico' => mysql_real_escape_string($_POST['nom_medico_fs']),
                        'tel_medico' => mysql_real_escape_string($_POST['tel_medico_fs']),
                        'nom_medico2' => mysql_real_escape_string($_POST['nom_medico2_fs']),
                        'tel_medico2' => mysql_real_escape_string($_POST['tel_medico2_fs']),
                        'nom_medico3' => mysql_real_escape_string($_POST['nom_medico3_fs']),
                        'tel_medico3' => mysql_real_escape_string($_POST['tel_medico3_fs']),
                        'no_pasaporte' => mysql_real_escape_string($_POST['pasaporte_fs']),
                        'fecha_nac' => $fecha,
                        'peso' => mysql_real_escape_string($_POST['peso_fs']),
                        'estatura' => mysql_real_escape_string($_POST['estatura_fs']),
                        'sexo' => mysql_real_escape_string($_POST['sexo_fs']),
                        'foto' => mysql_real_escape_string($_POST['foto_fs'])
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


if (!empty($user) && empty($_POST)) {
    $_POST['nombre_fs'] = $user->nombre;
    $_POST['ap_paterno_fs'] = $user->ap_paterno;
    $_POST['ap_materno_fs'] = $user->ap_materno;
    $_POST['nom_emergencia_fs'] = $user->encargado_emergencia;
    $_POST['tel_emergencia_fs'] = $user->tel_emergencia;
    $_POST['nom_emergencia2_fs'] = $user->encargado_emergencia2;
    $_POST['tel_emergencia2_fs'] = $user->tel_emergencia2;
    $_POST['nom_emergencia3_fs'] = $user->encargado_emergencia3;
    $_POST['tel_emergencia3_fs'] = $user->tel_emergencia3;
    $_POST['correo_emergencia_fs'] = $user->correo_emergencia;
     $_POST['numero_celular_fs'] = $user->numero_celular;
    $_POST['nom_medico_fs'] = $user->nom_medico;
    $_POST['tel_medico_fs'] = $user->tel_medico;
    $_POST['nom_medico2_fs'] = $user->nom_medico2;
    $_POST['tel_medico2_fs'] = $user->tel_medico2;
    $_POST['nom_medico3_fs'] = $user->nom_medico3;
    $_POST['tel_medico3_fs'] = $user->tel_medico3;
    $_POST['pasaporte_fs'] = $user->no_pasaporte;
    $_POST['peso_fs'] = $user->peso;
    $_POST['estatura_fs'] = $user->estatura;
    $_POST['sexo_fs'] = $user->sexo;
    $_POST['foto_fs'] = $user->foto;

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
                            .consejo{
                                display: inline-block;
                                margin-left: 10px;
                                font-style: italic;
                            }
                            #archivo{
                                width: 40%;
                                height: auto;
                                background-color: #ccc;
                                float:right;
                            }
                        </style>

                        <div id="respond">
                            <?php
                            if (is_user_logged_in()):
                                echo $response;
                                ?>
                                <p>
                                    <span class="label label-default">Tipo de imagen permitida: Jpeg, Jpg, Png y Gif. | Tama&ntilde;o maximo 0.5 MB</span>
                                <form action="http://lifeband.com.mx/subir.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
                                    <label for="foto">Foto: 
                                        <br>
                                        <img alt="Foto" id="archivo" src="<?php echo $fotosrc; ?>">
                                        <div id="output"></div>
                                        <input type="hidden" name="rsu_fs" value="<?php echo $current_user->user_login; ?>">
                                        <input name="archivo" id="imageInput" type="file" />
                                        <input type="submit"  id="submit-btn" value="Subir" />
                                        <img src="http://lifeband.com.mx/wp-content/themes/enfold/images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Cargando..."/>
                                    </label>
                                </form>

                                </p>

                                <form action="<?php the_permalink(); ?>" method="post">
                                    <!--<h3>Datos basicos</h3>-->
                                    <input type="hidden" id="foto" name="foto_fs" value="<?php echo esc_attr($_POST['foto_fs']); ?>">
                                    <p><label for="nombre">Nombre / Name: <span>*</span>
                                            <br>
                                            <input type="text" required="required" name="nombre_fs" value="<?php echo esc_attr($_POST['nombre_fs']); ?>"></label>
                                    </p>
                                    <p><label for="ap_paterno">Apellido paterno / Last Name: <span>*</span> <br>
                                            <input type="text" required="required" name="ap_paterno_fs" value="<?php echo esc_attr($_POST['ap_paterno_fs']); ?>"></label></p>
                                    <p><label for="ap_materno">Apellido materno / Mother's Maiden Name:  <br>
                                            <input type="text" name="ap_materno_fs" value="<?php echo esc_attr($_POST['ap_materno_fs']); ?>"></label></p>
                                    <p><label for="nom_emergencia">Nombre del encargado de emergencia / Name of the family member or close friend to call:
                                            <span class="consejo">Persona a informarle de alg&uacute;n percance / Person to call</span>
                                            <br>
                                            <input type="text" name="nom_emergencia_fs" value="<?php echo esc_attr($_POST['nom_emergencia_fs']); ?>"></label></p>
                                    <p><label for="tel_emergencia">Tel&eacute;fono de emergencia / Emergency Number: 
                                            <span class="consejo">Numero de la persona a informarle con lada / Number with lada </span>
                                            <br>
                                            <input type="text" name="tel_emergencia_fs" value="<?php echo esc_attr($_POST['tel_emergencia_fs']); ?>"></label></p>
                                    <p><label for="nom_emergencia2">Nombre del encargado de emergencia adicional / Name of the family member or close friend to call 2: 
                                            <span class="consejo">Persona adicional para informar / Person to call</span>
                                            <br>
                                            <input type="text" name="nom_emergencia2_fs" value="<?php echo esc_attr($_POST['nom_emergencia2_fs']); ?>"></label></p>
                                    <p><label for="tel_emergencia2">Tel&eacute;fono de emergencia adicional / Emergency Number 2:  
                                            <span class="consejo">Numero de la persona adicional / Person to call</span>
                                            <br>
                                            <input type="text" name="tel_emergencia2_fs" value="<?php echo esc_attr($_POST['tel_emergencia2_fs']); ?>"></label></p>
                                    <p><label for="nom_emergencia3">Nombre del encargado de emergencia adiconal 2 / Name of the family member or close friend to call 2:
                                            <span class="consejo">Segunda persona adicional para informar / Person to call</span>
                                            <br>
                                            <input type="text" name="nom_emergencia3_fs" value="<?php echo esc_attr($_POST['nom_emergencia3_fs']); ?>"></label></p>
                                    <p><label for="tel_emergencia3">Tel&eacute;fono de emergencia adicional / Emergency Number 2:  
                                            <span class="consejo">Numero de la segunda persona adicional a informar</span>
                                            <br>
                                            <input type="text" name="tel_emergencia3_fs" value="<?php echo esc_attr($_POST['tel_emergencia3_fs']); ?>"></label></p>
                                    <p><label for="correo_emergencia">Correo de emergencia / Emergency e-mail :  
                                            <span class="consejo">Para mandar un informe de sobre un percance / Email to send a message</span>
                                            <br>
                                            <input type="email" name="correo_emergencia_fs" value="<?php echo esc_attr($_POST['correo_emergencia_fs']); ?>"></label></p>
                                    <p><label for="nom_medico">Nombre del m&eacute;dico /Name of the Physicians:  
                                            <span class="consejo">Nombre y apellido del medico adicional / Name with last name of your second Additional Physician</span>
                                            <br>
                                            <input type="text" name="nom_medico_fs" value="<?php echo esc_attr($_POST['nom_medico_fs']); ?>"></label></p>
                                    <p><label for="tel_medico">Tel&eacute;fono del m&eacute;dico / Physicians Phone:
                                            <span class="consejo">Ex: (555)555 55 55</span>
                                            <br>
                                            <input type="text" name="tel_medico_fs" value="<?php echo esc_attr($_POST['tel_medico_fs']); ?>"></label></p>
                                    <p><label for="numero_cel">Tel&eacute;fono celular / Cellphone Number:
                                            <span class="consejo">Ex: (555)555 55 55</span>
                                            <br>
                                            <input type="text" name="numero_celular_fs" value="<?php echo esc_attr($_POST['numero_celular_fs']); ?>"></label></p>
                                    <p><label for="nom_medico2">Nombre del m&eacute;dico  / Name of Physician:  
                                            <span class="consejo">Nombre y apellido del medico adicional / Name with last name of your second Additional Physician</span>
                                            <br>
                                            <input type="text" name="nom_medico2_fs" value="<?php echo esc_attr($_POST['nom_medico2_fs']); ?>"></label></p>
                                    <p><label for="tel_medico2">Tel&eacute;fono del m&eacute;dico adicional / Additional Physicians Phone:  
                                            <span class="consejo">Ex: (555)555 55 55</span>
                                            <br>
                                            <input type="text" name="tel_medico2_fs" value="<?php echo esc_attr($_POST['tel_medico2_fs']); ?>"></label></p>
                                    <p><label for="nom_medico3">Nombre del m&eacute;dico adicional 2 / Name of the Additional Physicians 2: 
                                            <span class="consejo">Nombre y apellido del segundo medico adicional / Name with last name of your second Additional Physician</span>
                                            <br>
                                            <input type="text" name="nom_medico3_fs" value="<?php echo esc_attr($_POST['nom_medico3_fs']); ?>"></label></p>
                                    <p><label for="tel_medico3">Tel&eacute;fono del m&eacute;dico adicional 2 / Additional Physicians Phone 2: 
                                            <span class="consejo">Ex: (555)555 55 55</span>
                                            <br>
                                            <input type="text" name="tel_medico3_fs" value="<?php echo esc_attr($_POST['tel_medico3_fs']); ?>"></label></p>
                                    <p><label for="pasaporte">Numero de pasaporte / Passport number: 
                                            <span class="consejo">Debe ser entre 9 o 10 digitos / Must be between 9 or 10 digits</span>
                                            <br>
                                            <input type="text" name="pasaporte_fs" value="<?php echo esc_attr($_POST['pasaporte_fs']); ?>"></label></p>
                                    <p><label for="edad">Fecha de  / Date of birth:  <br>
                                            <label for="dia">D&iacute;a / Day</label>
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
                                            <label for="mes">Mes / Month</label>
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
                                            <label for="anio">A&ntilde;o / Year</label>
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
                                            <p><label for="peso">Peso en Kilogramos / Weight in Kilograms: 
                                                    <span class="consejo">Ex: 65.5</span>
                                                    <br>
                                                    <input type="text" size="5" name="peso_fs" value="<?php echo esc_attr($_POST['peso_fs']); ?>"></label></p>
                                            <p><label for="estatura">Estatura en Metros / Height in Meters :
                                                    <span class="consejo">Ex: 1.60</span>
                                                    <br>
                                                    <input type="text" size="5" name="estatura_fs" value="<?php echo esc_attr($_POST['estatura_fs']); ?>"></label></p>
                                            <p class="one-line"><label for="sexo">Sexo / Genre: </label> <br>
                                                <input type="radio" name="sexo_fs" id="sexo_m" value="M" <?php
                                        if ($_POST['sexo_fs'] == 'M') {
                                            echo 'checked';
                                        }
                                                ?>><label for="sexo_m">Masculino / Male</label>
                                                <input type="radio" name="sexo_fs" id="sexo_f" value="F" <?php
                                               if ($_POST['sexo_fs'] == 'F') {
                                                   echo 'checked';
                                               }
                                                ?>><label for="sexo_f">Femenino / Female</label></p>
                                            <!--<p><label for="message_human">Verificaci&oacute;n: <span>*</span> <br><input type="text" required="required" style="width: 60px;" name="message_human"> + 3 = 5</label></p>-->      

                                                                                                    <!--                  <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" value="<?php // echo esc_attr($_POST['message_name']);                 ?>"></label></p>
                                                                                                    <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" value="<?php //echo esc_attr($_POST['message_email']);                 ?>"></label></p>
                                                                                                    <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" name="message_text"><?php //echo esc_textarea($_POST['message_text']);                 ?></textarea></label></p>
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
        <?php
        //get the sidebar
        $avia_config['currently_viewing'] = 'page';

        get_sidebar();
        ?>
    </div><!-- #primary -->

    <script type='text/javascript' src='http://lifeband.com.mx/wp-content/themes/enfold/js/jquery.form.min.js'></script>
    <script type="text/javascript">
        var json={};
        $(document).ready(function() { 
            var options = { 
                target:   json,   // target element(s) to be updated with server response 
                beforeSubmit:  beforeSubmit,  // pre-submit callback 
                success:       afterSuccess,  // post-submit callback 
                resetForm: true        // reset the form after successful submit 
            }; 
		
            $('#MyUploadForm').submit(function() { 
                $(this).ajaxSubmit(options);  			
                // always return false to prevent standard browser submit and page navigation 
                return false; 
            }); 
        }); 

        function afterSuccess(data)
        {
            console.log(data);
            $('#submit-btn').show(); //hide submit button
            $('#loading-img').hide(); //hide submit button
            json=JSON.parse(data);
            switch(json.status){
                case "ok":
                    
                    $('#archivo').attr('src','http://lifeband.com.mx/fotos/'+json.data);
                    $('#foto').val(json.data);
                    $('#output').html('Cargada la foto con exito!');
                    //html('<img alt="Foto" src="'+json.data+'">');
                    break;
                //case "info":
            case "error":
                $('#output').html(json.data);
                
                break;
            default: break;
            }
        }

        //function to check file size before uploading.
        function beforeSubmit(){
            //check whether browser fully supports all File API
            if (window.File && window.FileReader && window.FileList && window.Blob)
            {
		
                if( !$('#imageInput').val()) //check empty input filed
                {
                    $("#output").html("No haz seleccionado una imagen.");
                    return false
                }
		
                var fsize = $('#imageInput')[0].files[0].size; //get file size
                var ftype = $('#imageInput')[0].files[0].type; // get file type
		

                //allow only valid image file types 
                switch(ftype)
                {
                    case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                                    break;
                                default:
                                    $("#output").html("<b>"+ftype+"</b> Formato de imagen no soportado");
                                    return false
                            }
		
                            //Allowed file size is less than 0.5 MB (524288)
                            if(fsize>524288) 
                            {
                                $("#output").html("<b>"+bytesToSize(fsize) +"</b> La imagen es muy grande! <br />				Por favor intente con otra imagen m&aacute;s peque&ntilde;a o redusca el tama&ntilde; de la imagen con un editor de imagenes.");
                                return false
                            }
				
                            $('#submit-btn').hide(); //hide submit button
                            $('#loading-img').show(); //hide submit button
                            $("#output").html("");  
                        }
                        else
                        {
                            //Output error to older unsupported browsers that doesn't support HTML5 File API
                            $("#output").html("Por favor actualize o utilice otro navegador, por que su actual navegador no soporta las caracteristicas necesarias para el proceso de la imagen.");
                            return false;
                        }
                    }

                    //function to format bites bit.ly/19yoIPO
                    function bytesToSize(bytes) {
                        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                        if (bytes == 0) return '0 Bytes';
                        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
                    }

    </script>
    <?php get_footer(); ?>

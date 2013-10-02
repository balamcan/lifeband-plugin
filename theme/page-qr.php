<?php
/*
 * Template Name: Qr
 */
get_header();
$codigo=$_GET['code'];

//gives the full url
$urlqr=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
?>

<div id="primary" class="site-content">
    <div id="content" role="main">

<?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?> -<b> Informaci&oacute;n de $nombre $paterno $materno</b></h1>
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
                        <!--<h2>Informaci&oacute;n de $nombre $paterno $materno</h2>-->
                        <h3>Datos b&aacute;sicos</h3>
                        <p><label>Apellido paterno:</label><span>$paterno</span></p>
                        <p><label>Apellido materno:</label><span>$materno</span></p>
                        <p><label>Nombre:</label><span>$nombre</span></p>
                        <p><label>Nombre del encargado de emergencia:</label><span>$nombre_emergencia</span></p>
                        <p><label>Telefono de emergencia:</label><span>$telefono_emergencia</span></p>
                        <p><label>Correo de emergencia:</label><span>$correo_emergencia</span></p>
                        <p><label>Nombre del medico:</label><span>$nombre_medico</span></p>
                        <p><label>Telefono del medico:</label><span>$tel_medico</span></p>
                        <p><label>Edad:</label><span>$edad</span></p>
                        <p><label>Peso:</label><span>$peso</span></p>
                        <p><label>Estatura:</label><span>$estatura</span></p>
                        <p><label>Sexo:</label><span>$sexo</span></p>
                        
                        <h3>Datos medicos</h3>

                        <p><label>Tipo de sangre:</label><span>$tipo_sangre</span></p>
                        <p><label>Tipo de diabetes:</label><span>$tipo_diabetes</span></p>
                        <p><label>Presi&oacute;n arterial diastolica:</label><span>$presion_diastolica</span></p>
                        <p><label>Presi&oacute;n arterial sistolica:</label><span>$presion_sistolica</span></p>
                        <p><label>Donador de organos:</label><span>$donador_organos</span></p>
                        <p><label>Alergias:</label><span>$alergias</span></p>
                        <p><label>Medicamentos:</label><span>$medicamentos</span></p>
                        <p><label>Enfermedades:</label><span>$enfermedades</span></p>
                        <p><label>Cirugias:</label><span>$cirugias</span></p>
                        <p><label>Otras consideraciones:</label><span>$otras_consideraciones</span></p>
                        
                        <h3>Discapacidades y/o dispositivos</h3>
                        
                        <p><label>Discapacidad auditiva:</label><span>$auditiva</span></p>
                        <p><label>Discapacidad mental:</label><span>$mental</span></p>
                        <p><label>Discapacidad motora:</label><span>$motora</span></p>
                        <p><label>Discapacidad visual:</label><span>$visual</span></p>
                        <p><label>Dispositivo de soporte vital marcapasos:</label><span>$marcapasos</span></p>
                        <p><label>Lentes de contacto:</label><span>$lentes_contacto</span></p>
                        <p><label>Protesis dentales:</label><span>$protesis_dentales</span></p>
                        <p><label>Medicamentos de origen natural:</label><span>$med_naturales</span></p>
                        <div class="qr">
                            <?php
                        echo '<img src="http://localhost/qr/param.php?txt='.$urlqr.'"/>'; 
                        //echo '<img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl=http://'.$urlqr.'"/>';
                        echo'<p>'.'http://'.$urlqr.'</p>';
                            ?>
                        </div>
                    </div>

                </div><!-- .entry-content -->

            </article><!-- #post -->

<?php endwhile; // end of the loop.  ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
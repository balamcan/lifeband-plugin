<?php
/**
 * Crea una lista de archivos con respecto al archivo donde fue llamada la funcion.
 * @param String Puede ser "." o ".." o tambien cualquier directorio o ruta
 * que requerido
 * @return array Devuelve una lista de archivos
 */
function filesArreglo($dir) {
    $arreglo = array();
    $directorio = opendir($dir);
    while ($archivo = readdir($directorio)) {
        if (!is_dir("$dir/$archivo"))
            array_push($arreglo, $archivo);
//          echo$archivo;
    }
    closedir($directorio);
    return $arreglo;
}

$archivos = filesArreglo(".");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>

        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <title>Directorio de archivos</title>
    </head>
    <style type="text/css" rel="stylesheet">
        /*    #galeria div img,
            #galeria div span,*/
        #galeria div{
            display: inline-block;
            border: solid black 1px;
            text-align: center;
        }
    </style>
    <body>

        <div id="galeria">
            <?php
            foreach ($archivos as $fotos) {
                if ($fotos !== 'index.php') {
                    echo'<div>
                            <img src="' . $fotos . '"><br>
                            <span>' . $fotos . '</span>
                        </div>';
                }
//    echo $fotos;
            }
            ?>
        </div>


    </body>

</html>
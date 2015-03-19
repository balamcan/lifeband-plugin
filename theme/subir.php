<?php
// header('Content-type: application/json');
  $obj=new stdClass();
if( !isset($_FILES['archivo']) ){
  $obj->data=
  'Ha habido un error, tienes que elegir un archivo<br/>';
  $obj->status='error';
  
//  echo '<a href="index.html">Subir archivo</a>';
}else{
  //agregando rotacion de la imagen
  //require 'http://lifeband.com.mx/watimage.php';
  $rotate=-1*($_POST['angulo_fs']);

  $nombre = $_FILES['archivo']['name'];
  $nombre_tmp = $_FILES['archivo']['tmp_name'];
  $tipo = $_FILES['archivo']['type'];
  $tamano = $_FILES['archivo']['size'];
  $ext_permitidas = array('jpg','jpeg','gif','png');
  $partes_nombre = explode('.', $nombre);
  $extension = end( $partes_nombre );
  $ext_correcta = in_array($extension, $ext_permitidas);


    


  $nombreNuevo=$_POST["rsu_fs"] .".".$extension;
  $target = 'fotos/'.$nombreNuevo;

  $tipo_correcto = preg_match('/^image\/(pjpeg|jpeg|gif|png)$/', $tipo);
 
  $limite = 512 * 1024;

  if( $ext_correcta && $tipo_correcto && $tamano <= $limite ){
    if( $_FILES['archivo']['error'] > 0 ){
      $obj->data=
      'Error: ' . $_FILES['archivo']['error'] . '<br/>';
      
      $obj->status='error';
    }else{
      //echo '<img src="'.$target.'" alt="Perfil" style="width: 400px;">';
      /*echo 'Nombre: ' . $nombre . '<br/>';
      echo 'Tipo: ' . $tipo . '<br/>';
      echo 'Tamaño: ' . ($tamano / 1024) . ' Kb<br/>';
      echo 'Guardado en: ' . $nombre_tmp;
      */
      if (file_exists($target)) {
      /*$obj->data=
        'Ya exist&iacute;a la imagen y se remplazó!';
      $obj->status='info';
      */
          unlink($target); // Delete now
      } 
      $obj->data=$nombreNuevo;
      $obj->status='ok';
      $obj->rotate_fs=$rotate;
      
      //copiando a la carpteta destino y con el nombre predefinido
        move_uploaded_file($nombre_tmp,
          $target);

    $img_r = imagecreatefromjpeg($target);
    // $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
    //copia una porción rectangular de una imagen a otra imagen,
    //interpolando de manera suave los valores de los píxeles por 
    //lo que, particularmete, al reducir el tamaño de una imagen, 
    //ésta todavía conserva mucha nitidez. 
      // $imagen=imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
      // $targ_w,$targ_h,$_POST['w'],$_POST['h']);
    if(!empty($rotate)){
        $dst_r = imagerotate($img_r, $rotate, 0);

        $obj->dorotateandsave=true;
        imagejpeg($dst_r, $target);
          
    }


 
        //echo "<br/>Guardado en: " . "archivos/" . $nombre;
    }
  }else{
      $obj->data='Archivo inv&aacute;lido';
      $obj->status='error';
  }
}
echo json_encode($obj);
?>

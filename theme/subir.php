<?php

  $obj=new stdClass();
if( !isset($_FILES['archivo']) ){
  $obj->data=
  'Ha habido un error, tienes que elegir un archivo<br/>';
  $obj->status='error';
  
//  echo '<a href="index.html">Subir archivo</a>';
}else{
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

      
      //copiando a la carpteta destino y con el nombre predefinido
        move_uploaded_file($nombre_tmp,
          $target);
 
        //echo "<br/>Guardado en: " . "archivos/" . $nombre;
    }
  }else{
      $obj->data=
     'Archivo inv&aacute;lido';
      $obj->status='error';
  }
}
echo json_encode($obj);
?>

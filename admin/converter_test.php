<!doctype html>
<?php
//conection:
require_once('generateUsers.php');
$userFactory = new generateUsers();
$link = mysqli_connect("localhost","root","1122334455","wordpress2") or die("Error " . mysqli_error($link));
if(!empty($_POST['evento_a_borrar_fs']))
    {
         $eventoQueSeraBorrado =$_POST['evento_a_borrar_fs'];
         $userFactory->deleteUserByEvent($eventoQueSeraBorrado);
    
    }
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Convertidor</title>
</head>
<body>
	 <form method="post" action="<?php echo  $_SERVER['REQUEST_URI']; ?>">
        
        <div class="row">
           <label for="evento">Seleccione Evento:</label>

            <select type="text" name="evento_a_borrar_fs" id="evento" value="50">
              
                        echo'<option value="'+3+'">hola</option>';
               
            </select>
        </div>
        <div class="row">
            <input type="submit" name="submit" value="Borrar Usuarios">
        </div>
    </form>
</body>
    <script type="text/javascript" src="jquery-1.11.0.min.js"></script>
            <script type="text/javascript" src="Converter.js"></script>
</html>
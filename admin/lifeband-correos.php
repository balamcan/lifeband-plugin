<?php  
$servername = "localhost";
$username = "root";
$password = "1122334455";
$dbname = "wordpress2";
include_once(ABSPATH . '/wp-includes/wp-db.php');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
echo '<link rel="stylesheet" type="text/css" href="style_pe.css" media="screen" />';
$result = $wpdb->get_results('SELECT * FROM wp_correos_evento', ARRAY_A);

?>
<!DOCTYPE html>
<html>
<head>
<title>Title of the document</title>
</head>

<body>
<?php
echo "<table border='1'>
<tr>
<th>Nombre(s)</th>
<th>Apellido Paterno</th>
<th>Apellido Materno</th>
<th>Fecha Nacimiento</th>
<th>Correo</th>
</tr>";

foreach($result as $row){
  echo "<tr>";
  echo "<td>" . $row['nombre'] . "</td>";
  echo "<td>" . $row['ap_paterno'] . "</td>";
  echo "<td>" . $row['ap_materno'] . "</td>";
  echo "<td>" . $row['fecha_nac'] . "</td>";
  echo "<td>" . $row['correo'] . "</td>";
  echo "</tr>";
}

echo "</table>";




?>
</body>

</html>
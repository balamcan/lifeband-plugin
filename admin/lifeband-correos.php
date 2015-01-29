<?php  

include_once(ABSPATH . '/wp-includes/wp-db.php');
echo '<link rel="stylesheet" type="text/css" href="style_pe.css" media="screen" />';
if (!empty($_GET['pagina'])) {
    $inicio = $_GET['pagina'];
}
else{
	$inicio = 1;
} 
$fin = 3;
$result = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'correos_evento limit ' . $inicio . ','.$fin, ARRAY_A);
$qNumberOfRows = $wpdb->get_results('SELECT Count(*) as number FROM '.$wpdb->prefix.'correos_evento', ARRAY_A);
foreach($qNumberOfRows as $row){
    $numberOfRows = $row[0];
}
$numberOfRows = ceil($numberOfRows / $fin);
?>
<!DOCTYPE html>
<html>
<head>
<title>Correos Plantilla</title>
</head>

<body>
<?php
$paginator = paginator($numberOfRows);
echo implode(" | ", $paginator);
echo "<table>
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
echo implode(" | ", $paginator);
function paginator($total_paginas,$pagina=1)
{	

	if ($total_paginas > 1) {
		for ($i = 1; $i  <= $total_paginas; $i++) {
			if ($pagina == $i) {
				$paginacion[]= $pagina . ' ';
			} else {
				$paginacion[]= '<a href="http://lifeband.com.mx/wp-admin/admin.php?page=lifeband-plugin-menu&pagina=' . $i . '">' . $i . '</a>';
			}
		}
	}
	return $paginacion;
}



?>
</body>

</html>
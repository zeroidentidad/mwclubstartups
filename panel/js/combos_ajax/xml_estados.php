<?php
require "../../util/conn.php";
$anio = (isset($_GET["anio"]))?$_GET["anio"]:"";
$sql = "SELECT * FROM estados e" /*WHERE e.anio=".$anio*/;
$sql.= " ORDER BY e.nombre";
$r = mysqli_query($conn, $sql);
// Generar XML:
print header("Content-type:text/xml");
print "<?xml version='1.0' encoding='UTF-8'?>";
print "<estados>";
while ($datos = mysqli_fetch_object($r)){
	$id_estado = $datos->id_estado;
	$nombre = $datos->nombre;
 // crear nodo
	print "<estado>";
	print "<id_estado>".$id_estado."</id_estado>";
	print "<nombre>".$nombre."</nombre>";
	print "</estado>";	
}
print "</estados>";
mysqli_close($conn);
?>
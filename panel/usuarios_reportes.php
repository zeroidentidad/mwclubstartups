<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/UsuariosReportes.php";

$reporte_usuario_ = new UsuariosReportes();
$num = $reporte_usuario_->numeroRegistros($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"]):
S - Consulta (select)
*/

// Validaciones modos:
if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $reporte_usuario_->select($conn, $inicio_p, $TAMANO_PAGINA);
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Usuarios</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="./js/librerias_ui/popper.min.js"></script>
	<!--<script src="./js/librerias_ui/jquery-3.3.1.min.js"></script>-->	<!-- cuando se requiera AJAX -->
	<script src="./js/librerias_ui/jquery-3.3.1.slim.min.js"></script>	
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/librerias_ui/bootstrap.min.js"></script>
	<!-- JS-CSS JAFS -->
	<link rel="stylesheet" href="./css/estilos.css">	
	<script type="text/javascript"><?php require "./js/usuarios_reportes_js.php"; ?></script>
</head>

<body>
	<?php require "menu-nav.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<label for="lista"></label>
					<input type="button" name="lista" value="IMPRIMIR LISTA" class="btn btn-info" role="button" id="lista">
				<?php } ?>				
			</div>
			<div class="col-sm-8 text-center">
				<h2>Reportes de usuarios <?php print "(".$num.")"; ?></h2>
				<?php require "util/mensajes.php"; ?>
				<div class="table-responsive">
				<?php

				if ($modo=="S") {
					print '<table class="table table-striped" with="100%">';
					print '<tr>';
					print '<th>Usuario</th>';
					print '<th>Nombre</th>';
					print '<th>Imprimir datos</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["usuario"].'</td>';
					print '<td>'.$datos[$i]["nombre"].' '.$datos[$i]["apellidos"].'</td>';
					print '<td><a class="btn btn-outline-secondary" href="reportes/usuario_rpt.php?id_usuario='.$datos[$i]["id_usuario"].'&usuario='.$datos[$i]["usuario"].'">PDF</a></td>';
					print '</tr>';
					}
					print '</table>';
					print '</div>';

					/**** PAGINACION TABLA ****/
					require "util/paginar_tabla_html.php";
					
				}

				?>
			</div>
		</div>
	</div>

	<?php require "footer.php";?>
</body>
</html>
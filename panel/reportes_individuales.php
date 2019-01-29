<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/ReportesIndividuales.php";

$reporte_individual_ = new ReportesIndividuales();
$num = $reporte_individual_->numeroRegistros($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"]):
S - Consulta (select)
*/

/** Variables de busqueda **/
$filtro="";
$columna="";

// Validaciones modos:
if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $reporte_individual_->select($conn, $inicio_p, $TAMANO_PAGINA, "", "");
}

if (isset($_POST['buscar'])){
	$filtro = $_POST["buscarpor"];
	$columna = $_POST["columna"];
	$datos = $reporte_individual_->select($conn, $inicio_p, $TAMANO_PAGINA, $filtro, $columna);
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Registros</title>
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
	<script type="text/javascript"><?php require "./js/reportes_individuales_js.php"; ?></script>
</head>

<body>
	<?php require "menu-nav.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<form method="post" action="reportes_individuales.php">
						<div class="form-group">
						<input class="text-left" type="text" id="buscarpor" name="buscarpor" value='<?php print $filtro ?>' placeholder="Buscar por..." />
						</div>
						<!-- -->
						<div class="form-group">
						<select class="dropdown" id="columna" name="columna">
							<option value="">-SELECCIONAR-</option>
							<option <?php if($columna=='folio') print 'selected'; ?> value="folio">FOLIO</option>
							<option <?php if($columna=='nombre') print 'selected'; ?> value="nombre">NOMBRE</option>
							<option <?php if($columna=='matricula') print 'selected'; ?> value="matricula">NDI</option>
						</select>
						</div>
					    <!-- --> <!-- cuando se requiera agregar filtros -->
						<div class="form-group">
						<input type="submit" id="buscar" name="buscar" value="BUSCAR" class="btn btn-outline-secondary" role="button" />
						</div>
					</form>					
				<?php } ?>				
			</div>
			<div class="col-sm-8 text-center">
				<h2>Reportes de registros <?php print "(".$num.")"; ?></h2>
				<?php require "util/mensajes.php"; ?>
				<div class="table-responsive">
				<?php

				if ($modo=="S") {
					print '<table class="table table-striped" with="100%">';
					print '<tr>';
					print '<th>Folio</th>';
					print '<th>Nombre</th>';
					print '<th>Apellidos</th>';
					print '<th>NDI</th>';
					print '<th>Imprimir datos</th>';
					print '<th>Constancia</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["id_folio"].'</td>';
					print '<td>'.$datos[$i]["nombre"].'</td>';
					print '<td>'.$datos[$i]["apellidos"].'</td>';
					print '<td>'.$datos[$i]["matricula"].'</td>';
					print '<td><a class="btn btn-outline-secondary" href="reportes/registro_datos_rpt.php?id_folio='.$datos[$i]["id_folio"].'">PDF</a></td>';
					print '<td><a class="btn btn-outline-secondary" href="reportes/registro_constancia_rpt.php?id_folio='.$datos[$i]["id_folio"].'">PDF</a></td>';
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
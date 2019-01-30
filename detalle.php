<?php
require "./panel/util/conn.php";
require "./util/variables_globales.php";
require "./clases/DetalleMovil.php";

$contactos_ = new DetalleMovil();
$num = $contactos_->numeroRegistros($conn);

require "util/variables_paginacion.php";

// Validaciones modos:
if (isset($_GET["modo"])&&isset($_GET["co"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$id_folio = $_GET["co"];
	$datos = $contactos_->select($conn, $inicio_p, $TAMANO_PAGINA, $id_folio);
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Registro Móvil</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
	<link rel="stylesheet" href="./js/jquery-mobile/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="./css/estilos.css">
	<script src="./js/jquery-2.2.4.min.js"></script>
	<!--<script> $(document).bind("mobileinit", function(){ $.extend( $.mobile , { ajaxEnabled: false }); }); </script>-->
	<script src="./js/jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
	<script src="./js/manipulacion_ui.js?v=<?php echo(rand()); ?>"></script>
	<script type="text/javascript"><?php require "./js/listado_js.php"; ?></script>
</head>
<body>
<div data-role="page" id="divContactos" data-theme="a">	
	<div data-role="header" id="divHeader">
		<a href="./" class="ui-btn-left" data-theme="b"><b>LISTA</b></a>
		<h1>Lista:</h1>
		<a href="./nuevo.php" class="ui-btn-right" rel="external" data-theme="b"><b>AGREGAR</b></a>
	</div>
	<div data-role="content" id="divContent">
		<label><b>Filtrar listado página:</b></label>
		<?php require "./util/mensajes.php"; ?>
		<form>
			<input id="filterTable-input" data-type="search">
		</form>
		<?php if ($modo=="S") { ?>	
		<table data-role="table" id="contactos-table" data-filter="true" data-input="#filterTable-input" class="ui-responsive">
			<thead>
				<tr>
					<th data-priority="">Año</th>
					<th data-priority="persist">Estado</th>
					<th data-priority="1">Profesión</th>
					<th data-priority="2">Nombre</th>
					<th data-priority="3">Apellidos</th>
					<th data-priority="4">E-mail</th>
					<th data-priority="5">Celular</th>
					<th data-priority="6">Pais</th>
					<th data-priority="7">Nota Emp.</th>
				</tr>
			</thead>
			<tbody>
				<?php
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["anio"].'</td>';
					print '<td>'.$datos[$i]["estado_descripcion"].'</td>';
					print '<td>'.$datos[$i]["profesion_descripcion"].'</td>';
					print '<td>'.$datos[$i]["nombre"].'</td>';
					print '<td>'.$datos[$i]["apellidos"].'</td>';
					print '<td><a href="mailto:'.$datos[$i]["email"].'">'.$datos[$i]["email"].'</a></td>';
					print '<td><a href="tel:'.$datos[$i]["celular"].'">'.$datos[$i]["celular"].'</a></td>';
					print '<td>'.$datos[$i]["pais"].'</td>';
					print '<td>'.$datos[$i]["nota"].'</td>';
					print '</tr>';
					}
				?>
			</tbody>
		</table>
		<?php	/**** PAGINACION TABLA ****/
			require "util/paginar_tabla_html.php";
			}	
		?>
		<br>
		<div data-role="footer">
			<h1><a href="http://softcun.co.nf"><font color="#00802b">Hecho por <b>Jesus A. Ferrer S.</b></font></a></h1>
		</div>
	</div>
</div>	
</body>
</html>
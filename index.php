<?php
require "./panel/util/conn.php";
require "./util/variables_globales.php";
require "./clases/ListadoMovil.php";

$contactos_ = new ListadoMovil();
$num = $contactos_->numeroRegistros($conn);

require "util/variables_paginacion.php";

// Validaciones modos:
if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $contactos_->select($conn, $inicio_p, $TAMANO_PAGINA);
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
		<a href="./nuevo.php" class="ui-btn-left" rel="external" data-theme="b"><b>AGREGAR</b></a>
		<h1>Lista:</h1>
		<a href="./panel/" class="ui-btn-right" rel="external" data-theme="b"><b>PANEL PC</b></a>
	</div>
	<div data-role="content" id="divContent">
		<label><b>Filtrar listado página:</b></label>
		<?php require "./util/mensajes.php"; ?>
		<form>
			<input id="filterTable-input" data-type="search">
		</form>
		<?php if ($modo=="S") { ?>	
		<table data-role="table" id="contactos-table" data-mode="reflow" data-filter="true" data-input="#filterTable-input" class="lista ui-responsive" data-mode="columntoggle">
			<thead>
				<tr>
					<th data-priority="persist">Estado</th>
					<th data-priority="1">Profesión</th>
					<th data-priority="2">Nombre</th>
					<th data-priority="3">E-mail</th>
					<th data-priority="4">Celular</th>
					<th data-priority="5">Nota Emp.</th>
					<th data-priority="6">Detalle</th>
				</tr>
			</thead>
			<tbody>
				<?php
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["estado_descripcion"].'</td>';
					print '<td>'.$datos[$i]["profesion_descripcion"].'</td>';
					print '<td>'.$datos[$i]["nombre"].'</td>';
					print '<td><a data-theme="b" href="mailto:'.$datos[$i]["email"].'" class="ui-btn ui-corner-all ui-icon-mail ui-btn-icon-notext ui-btn-inline"></a></td>';
					print '<td><a data-theme="b" href="tel:'.$datos[$i]["celular"].'" class="ui-btn ui-corner-all ui-icon-phone ui-btn-icon-notext ui-btn-inline"></a></td>';
					print '<td><font size="1">'.$datos[$i]["nota"].'</font></td>';
					print '<td><a href="./detalle.php?co='.$datos[$i]["id_folio"].'" class="ui-btn ui-mini">Ver</a></td>';
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
	</div>
	<div data-role="footer">
		<h1><a href="http://softcun.co.nf"><font color="#00802b">Hecho por <b>Jesus A. Ferrer S.</b></font></a></h1>
	</div>	
</div>	
</body>
</html>
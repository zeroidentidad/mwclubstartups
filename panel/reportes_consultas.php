<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/ReportesConsultas.php";

$reporte_consulta_ = new ReportesConsultas();
$num = $reporte_consulta_->numeroRegistros($conn);

$combo_profesiones = $reporte_consulta_->combo_profesiones($conn);

$combo_anios= $reporte_consulta_->combo_anios($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"]):
S - Consulta (select)
*/

/** Variables de busqueda **/
$anio="";
$folio="";
$nombre="";
$apellidos="";
$sexo="";
$profesion="";
$matricula="";
$email="";
$celular="";
$nota="";

// Validaciones modos:
if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $reporte_consulta_->select($conn, $inicio_p, $TAMANO_PAGINA, "", "", "", "", "", "", "", "", "", "");
}

if (isset($_POST['buscar'])){
	$anio = $_POST["anio"];
	$folio = $_POST["id_folio"];
	$nombre = $_POST["nombre"];
	$apellidos = $_POST["apellidos"];
	$sexo = $_POST["sexo"];
	$profesion = $_POST["profesion"];
	$matricula = $_POST["matricula"];
	$email = $_POST["email"];
	$celular = $_POST["celular"];
	$nota = $_POST["nota"];
	//echo var_dump($anio);
	$datos = $reporte_consulta_->select($conn, $inicio_p, $TAMANO_PAGINA, $anio, $folio, $nombre, $apellidos, $sexo, $profesion, $matricula, $email, $celular, $nota);
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Registros Consultas</title>
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
	<script type="text/javascript"><?php require "./js/reportes_consultas_js.php"; ?></script>	
</head>

<body>
	<?php require "menu-nav.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-4">
				<?php if($modo=="S"){ ?>
					<form method="post" action="reportes_consultas.php">
						<div class="form-group">
						<select class="dropdown" style="width:168px;" id="anio" name="anio">
							<option value="">-AÑO-</option>
							<?php
								for($i = 0; $i<count($combo_anios); $i++){
									$l = $combo_anios[$i]["anio"];
									print "<option value='";
									print $combo_anios[$i]["anio"]."' ";
									if($combo_anios[$i]["anio"]==$anio) print "selected";
									print ">".$l;
									print "</option>";
								}
							?>							
						</select>
						</div>						
						<div class="form-group">
						<input class="text-left" type="text" id="id_folio" name="id_folio" value='<?php print $folio ?>' placeholder="Folio..." />
						</div>
						<div class="form-group">
						<input class="text-left" type="text" id="nombre" name="nombre" value='<?php print $nombre ?>' placeholder="Nombre..." />
						</div>
						<div class="form-group">
						<input class="text-left" type="text" id="apellidos" name="apellidos" value='<?php print $apellidos ?>' placeholder="Apellidos..." />
						</div>
						<div class="form-group">
						<select class="dropdown" style="width:168px;" id="sexo" name="sexo">
							<option value="">-SEXO-</option>
							<option <?php if($sexo==1) print 'selected'; ?> value="1">FEMENINO</option>
							<option <?php if($sexo==2) print 'selected'; ?> value="2">MASCULINO</option>
						</select>
						</div>
						<div class="form-group">
						<select class="dropdown" style="width:168px;" id="profesion" name="profesion">
							<option value="">-PROFESIÓN-</option>
							<?php
								for($j = 0; $j<count($combo_profesiones); $j++){
									$k = $combo_profesiones[$j]["nombre"];
									print "<option value='";
									print $combo_profesiones[$j]["id_profesion"]."' ";
									if($combo_profesiones[$j]["id_profesion"]==$profesion) print "selected";
									print ">".$k;
									print "</option>";
								}
							?>
						</select>
						</div>
						<div class="form-group">
						<input class="text-left" type="text" id="matricula" name="matricula" value='<?php print $matricula ?>' placeholder="Matricula..." />
						</div>
						<div class="form-group">
						<input class="text-left" type="text" id="email" name="email" value='<?php print $email ?>' placeholder="E-mail..." />
						</div>
						<div class="form-group">
						<input class="text-left" type="text" id="celular" name="celular" value='<?php print $celular ?>' placeholder="Celular..." />
						</div>
						<div class="form-group">
						<input class="text-left" type="text" id="nota" name="nota" value='<?php print $nota ?>' placeholder="Fragmento nota..." />
						</div>

						<!-- Botones busqueda y reporte -->
						<div class="form-group">
						<input type="submit" id="buscar" name="buscar" value="BUSCAR" class="btn btn-outline-secondary" role="button" />
						</div>
						<div class="form-group">
						<input type="button" name="consulta" value="REPORTE" class="btn btn-info" role="button" id="consulta">
						</div>						
					</form>					
				<?php } ?>				
			</div>
			<div class="col-sm-10 text-center">
				<h2>Consultas de registros <?php print "(".$num.")"; ?></h2>
				<div class="input-group">
				<input class="form-control" style="width:100%;" id="fitrotabla" type="text" placeholder="Filtrar lista...">
				</div>
				<br>
				<?php require "util/mensajes.php"; ?>
				<div class="table-responsive">
				<?php

				if ($modo=="S") {
					print '<table id="mitabla" class="table table-striped" with="100%" style="overflow: scroll;" >';
					print '<tr>';
					print '<th>Año</th>';
					print '<th>Estado</th>';
					print '<th>Folio</th>';
					print '<th>Nombre</th>';
					print '<th>Apellidos</th>';
					print '<th>Sexo</th>';
					print '<th>Profesión</th>';
					print '<th>Matricula (DNI)</th>';
					print '<th>E-mail</th>';
					print '<th>Celular</th>';
					print '<th>Fragmento nota</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["anio"].'</td>';
					print '<td>'.$datos[$i]["estado_descripcion"].'</td>';
					print '<td>'.$datos[$i]["id_folio"].'</td>';
					print '<td>'.$datos[$i]["nombre"].'</td>';
					print '<td>'.$datos[$i]["apellidos"].'</td>';
					print '<td>'.$datos[$i]["sexo_descripcion"].'</td>';
					print '<td>'.$datos[$i]["profesion_descripcion"].'</td>';
					print '<td>'.$datos[$i]["matricula"].'</td>';
					print '<td>'.$datos[$i]["email"].'</td>';
					print '<td>'.$datos[$i]["celular"].'</td>';
					print '<td>'.html_entity_decode($datos[$i]["nota_fragmento"]).'...</td>';
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

	<?php require "footer.php"; ?>
</body>
</html>
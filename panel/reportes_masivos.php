<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/ReportesMasivos.php";

$reporte_masivo_ = new ReportesMasivos();
$num = $reporte_masivo_->numeroRegistros($conn);

$combo_profesiones = $reporte_masivo_->combo_profesiones($conn);

$combo_anios= $reporte_masivo_->combo_anios($conn);

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Registros Masivos</title>
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
	<script src="./js/reportes_masivos.js?v=<?php echo(rand()); ?>"></script>
</head>

<body>
	<?php require "menu-nav.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-4">
			</div>
			<div class="col-sm-8 text-center">
				<h2>Reportes de registros <?php print "(".$num.")"; ?></h2>
				<br>
				<?php require "util/mensajes.php"; ?>
				<div class="table-responsive">
					<table class="table table-striped" with="100%" style="overflow:scroll;" >
						<tr>
							<td>[1] <b>AÑO:</b></td>
							<td>
								<select class="dropdown" style="width:250px;" id="anio" name="anio">
									<option value="">-SELECCIONAR-</option>
									<?php
									for($i = 0; $i<count($combo_anios); $i++){
										$l = $combo_anios[$i]["anio"];
										print "<option value='";
										print $combo_anios[$i]["anio"]."' ";
										print ">".$l;
										print "</option>";
									}
									?>							
								</select>
							</td>
							<td>
								<input type="button" name="rpt_anual" value="Reporte Anual" class="btn btn-info" role="button" id="rpt_anual">
							</td>
							<td></td>
						</tr>
						<tr>
							<td>[2] <b>ESTADO:</b></td>
							<td>
								<select class="dropdown" style="width:250px;" id="estado" name="estado">
									<option value="">-SELECCIONAR-</option>						
								</select>
							</td>
							<td><input type="button" name="rpt_estado" value="Reporte Estado" class="btn btn-info" role="button" id="rpt_estado"></td>
							<td></td>
						</tr>
						<tr>
							<td>[3] <b>SEXO:</b></td>
							<td>
								<select class="dropdown" style="width:250px;" id="sexo" name="sexo">
									<option value="">-SELECCIONAR-</option>
									<option value="1">FEMENINO</option>
									<option value="2">MASCULINO</option>
								</select>
							</td>
							<td><input type="button" name="sexo_anual" value="Reporte Anual" class="btn btn-info" role="button" id="sexo_anual"></td>
							<td><input type="button" name="sexo_estado" value="Reporte Estado" class="btn btn-info" role="button" id="sexo_estado"></td>
						</tr>
						<tr>
							<td>[4] <b>PERFIL:</b></td>
							<td>
								<select class="dropdown" style="width:250px;" id="profesion" name="profesion">
									<option value="">-SELECCIONAR-</option>
									<?php
									for($j = 0; $j<count($combo_profesiones); $j++){
										$k = $combo_profesiones[$j]["nombre"];
										print "<option value='";
										print $combo_profesiones[$j]["id_profesion"]."' ";
										print ">".$k;
										print "</option>";
									}
									?>					
								</select>
							</td>
							<td><input type="button" name="prof_anual" value="Reporte Anual" class="btn btn-info" role="button" id="prof_anual"></td>
							<td><input type="button" name="prof_estado" value="Reporte Estado" class="btn btn-info" role="button" id="prof_estado"></td>
						</tr>																							
					</table>
				</div>	
			</div>
		</div>
	</div>

	<?php require "footer.php"; ?>
</body>
</html>
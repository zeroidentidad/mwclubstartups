<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/Estados.php";

$estado_ = new Estados();
$num = $estado_->numeroRegistros($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"]):
S - Consulta (select)
A - Agregar (insert)
B - Baja (pantalla de confirmacion antes de eliminar)
C - Cambio (update)
D - Baja definitiva (delete)
*/

/** Variables de agregar **/
$id_estado = "";
$anio = "";
$nombre = "";
$pais = "";
$estatus = "";
$descripcion = "";

$filtro="";
$columna="";

// Validaciones modos:
if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Delete definitivo
if ($modo=="D") {
	$id_estado = $_GET["id_estado"];
	$msg = $estado_->delete($conn, $id_estado);
}

// Deteccion insert-update por isset
if (isset($_POST["nombre"])){
	
	$id_estado = (isset($_POST["id_estado"]))?$_POST["id_estado"]:"";
	$anio = $_POST["anio"];
	$nombre = $_POST["nombre"];
	$pais = $_POST["pais"];
	$estatus = $_POST["estatus"];
	$descripcion = $_POST["descripcion"];

	$msg = $estado_->insert_update($conn, $id_estado, $anio, $nombre, $pais, $estatus, $descripcion);

}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $estado_->select($conn, $inicio_p, $TAMANO_PAGINA, "", "");
}

if (isset($_POST['buscar'])){
	$filtro = $_POST["buscarpor"];
	$columna = $_POST["columna"];
	$datos = $estado_->select($conn, $inicio_p, $TAMANO_PAGINA, $filtro, $columna);
}

// Modo cambio en registro
if ($modo=="C" || $modo=="B") {
	$id_estado = (isset($_GET["id_estado"]))?$_GET["id_estado"]:$id_estado;
	$datos = $estado_->obtener($conn, $id_estado);
	//paso datos del GET
	$nombre = $datos["nombre"];
	$pais = $datos["pais"];
	$estatus = $datos["estatus"];
	$descripcion = addslashes(htmlentities($datos["descripcion"]));
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Estados</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="./js/librerias_ui/popper.min.js"></script>
	<!--<script src="./js/librerias_ui/jquery-3.3.1.min.js"></script>-->	<!-- cuando se requiera AJAX -->
	<script src="./js/librerias_ui/jquery-3.3.1.slim.min.js"></script>	
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/librerias_ui/bootstrap.min.js"></script>
	<script src="./js/ckeditor5/ckeditor.js"></script>
	<!-- JS-CSS JAFS -->
	<link rel="stylesheet" href="./css/estilos.css">	
	<script type="text/javascript"><?php require "./js/estados_js.php"; ?></script>
</head>

<body>
	<?php require "menu-nav.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<div class="form-group">
					<label for="agregar"></label>
					<input type="button" name="agregar" value="NUEVO ESTADO" class="btn btn-info" role="button" id="agregar">
					</div>
					<form method="post" action="estados.php">
						<div class="form-group">
						<input class="text-left" type="text" id="buscarpor" name="buscarpor" value='<?php print $filtro ?>' placeholder="Buscar nombre..." />
						</div>
						<!-- -->
						<div class="form-group"> 
						<select class="dropdown" id="columna" name="columna">
							<option value="">-SELECCIONAR-</option>
							<option <?php if($columna=='nombre') print 'selected'; ?> value="nombre">NOMBRE</option>
							<option <?php if($columna=='id_estado') print 'selected'; ?> value="id_estado">NUMERO</option>
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
				<h2>Estados <?php print "(".$num.")"; ?></h2>
				<?php
				require "util/mensajes.php";
				if($modo=="A" || $modo=="C" || $modo=="B"){
				?>
				<form class="text-left" action="estados.php" method="post">
					<div class="form-group">
						<label for="nombre"><b>* N O M B R E :</b></label>
						<input type="text" name="nombre" id="nombre" class="form-control" required placeholder="El nombre del evento"
						value="<?php print $nombre; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="349" />
					</div>
					<div class="form-group">
						<label for="pais"><b>* P A I S :</b></label>
						<input type="text" name="pais" id="pais" class="form-control" required placeholder="pais donde se llevara a cabo" value="<?php print $pais; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="349" />
					</div>
					<div class="form-group">
						<label for="estatus"><b>* E S T A T U S :</b></label><br>
						<select class="dropdown" id="estatus" name="estatus" required>
						<option value="">-SELECCIONAR-</option>
						<option <?php if($estatus==1) print 'selected'; ?> value="1">ACTIVO</option>
						<option <?php if($estatus==2) print 'selected'; ?> value="2">INACTIVO</option>
						</select>
					</div>
					<div class="form-group">
						<label for="descripcion"><b>D E S C R I P C I Ó N :</b></label>
						<textarea name="descripcion" id="descripcion" <?php if($modo=="B") print 'disabled'; ?> rows="10" maxlength="999" > <?php print $descripcion; ?> </textarea>
					</div>									

					<!-- Campos ocultos necesarios: -->
					<input type="hidden" name="id_estado" id="id_estado" value="<?php print $id_estado; ?>" />
					<input type="hidden" name="anio" id="anio" value="<?php print date("Y"); ?>"/>
					<!-- -------------------------- -->

					<div class="form-group">
						<?php if($modo=="A" || $modo=="C"){ ?>
						<label for="enviar"></label>
						<input type="submit" name="enviar" id="enviar" class="btn btn-success" role="button" value="ENVIAR" />
						<label for="regresar"></label>
						<input type="button" name="regresar" id="regresar" class="btn btn-info" role="button" value="REGRESAR" />
						<?php } 

						if($modo=="B"){
						?>
						<label for="si-borrar">¿Desea borrar el registro?</label>
						<input type="button" name="si-borrar" id="si-borrar" class="btn btn-danger" role="button" value="SI" />
						<input type="button" name="no-borrar" id="no-borrar" class="btn btn-danger" role="button" value="NO" />
						<p>Una vez borrado el registro NO se podra recuperar.</p>
						<?php } ?>
					</div><br>								
				</form>
				<?php }

				if ($modo=="S") {
					print '<div class="table-responsive">';
					print '<table class="table table-striped" with="100%">';
					print '<tr>';
					print '<th>Num. Estado</th>';
					print '<th>Estado</th>';
					print '<th>Modificar</th>';
					print '<th>Borrar</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["id_estado"].'</td>';
					print '<td>'.$datos[$i]["nombre"].'</td>';
					print '<td><a class="btn btn-info" href="estados.php?modo=C&id_estado='.$datos[$i]["id_estado"].'">M</a></td>';
					print '<td><a class="btn btn-warning" href="estados.php?modo=B&id_estado='.$datos[$i]["id_estado"].'">B</a></td>';
					print '</tr>';
					}
					print '</table>';
					print '</div>';

					/**** PAGINACION TABLA ****/
					require "util/paginar_tabla_html.php";
					
				}

				?>
			</div>
			<div class="col-sm-2 sidenav"></div>
		</div>
	</div>

	<?php require "footer.php";?>
</body>
</html>
 <script>
    ClassicEditor
        .create( document.querySelector( '#descripcion' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
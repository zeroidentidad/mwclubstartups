<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/CatProfesiones.php";

$profesion_ = new CatProfesiones();
$num = $profesion_->numeroRegistros($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"]):
S - Consulta (select)
A - Agregar (insert)
B - Baja (pantalla de confirmacion antes de eliminar)
C - Cambio (update)
D - Baja definitiva (delete)
*/

/** Variables de agregar **/
$id_profesion = "";
$nombre = "";


// Validaciones modos:
if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Delete definitivo
if ($modo=="D") {
	$id_profesion = $_GET["id_profesion"];
	$msg = $profesion_->delete($conn, $id_profesion);
}

// Deteccion insert-update por isset
if (isset($_POST["nombre"])){
	
	$id_profesion = (isset($_POST["id_profesion"]))?$_POST["id_profesion"]:"";
	$nombre = $_POST["nombre"];

	$msg = $profesion_->insert_update($conn, $id_profesion, $nombre);

}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $profesion_->select($conn, $inicio_p, $TAMANO_PAGINA);
}

// Modo cambio en registro
if ($modo=="C" || $modo=="B") {
	$id_profesion = (isset($_GET["id_profesion"]))?$_GET["id_profesion"]:$id_profesion;
	$datos = $profesion_->obtener($conn, $id_profesion);
	//paso datos del GET
	$nombre = $datos["nombre"];	
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Profesiones</title>
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
	<script type="text/javascript"><?php require "./js/cat_profesiones_js.php"; ?></script>
</head>
<body>
<?php require "menu-nav.php" ?>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link" id="nav-cat-departamentos-tab" href="./cat_departamentos.php" role="tab" aria-controls="nav-cat-departamentos" aria-selected="false"><b>Departamentos</b></a>
    <a class="nav-item nav-link active" id="nav-cat-profesiones-tab" href="./cat_profesiones.php" role="tab" aria-controls="nav-cat-profesiones" aria-selected="true"><b>Profesiones</b></a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-cat-profesiones" role="tabpanel" aria-labelledby="nav-cat-profesiones-tab">

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<label for="agregar"></label>
					<input type="button" name="agregar" value="NUEVA PROFESION" class="btn btn-info" role="button" id="agregar">
				<?php } ?>				
			</div>
			<div class="col-sm-8 text-center">
				<h2>Profesiones <?php print "(".$num.")"; ?></h2>
				<?php
				require "util/mensajes.php";
				if($modo=="A" || $modo=="C" || $modo=="B"){
				?>
				<form class="text-left" action="cat_profesiones.php" method="post">
					<div class="form-group">
						<label for="nombre"><b>* N O M B R E :</b></label>
						<input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Nombre de la profesión"
						value="<?php print $nombre; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="149" />
					</div>															

					<!-- Campos ocultos necesarios: -->
					<input type="hidden" name="id_profesion" id="id_profesion" value="<?php print $id_profesion; ?>" />
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
					print '<th>Nombre</th>';
					print '<th>Modificar</th>';
					print '<th>Borrar</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["nombre"].'</td>';
					print '<td><a class="btn btn-info" href="cat_profesiones.php?modo=C&id_profesion='.$datos[$i]["id_profesion"].'">M</a></td>';
					print '<td><a class="btn btn-warning" href="cat_profesiones.php?modo=B&id_profesion='.$datos[$i]["id_profesion"].'">B</a></td>';
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

  </div>
</div>
<?php require "footer.php"; ?>
</body>
</html>
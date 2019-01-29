<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/Registros.php";

$registro_ = new Registros();
$num = $registro_->numeroRegistros($conn);

$combo_estados = $registro_->combo_estados($conn);

$combo_profesiones = $registro_->combo_profesiones($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"]):
S - Consulta (select)
A - Agregar (insert)
B - Baja (pantalla de confirmacion antes de eliminar)
C - Cambio (update)
D - Baja definitiva (delete)
*/

/** Variables de agregar **/
$id_folio = "";
$anio = "";
$id_estado = "";
$nombre = "";
$apellidos = "";
$sexo = "";
$profesion = "";
$matricula = "";
$email = "";
$celular = "";
$nota = "";

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
	$id_folio = $_GET["id_folio"];
	$msg = $registro_->delete($conn, $id_folio);
}

// Deteccion insert-update por isset
if (isset($_POST["id_estado"])){
	
	$id_folio = (isset($_POST["id_folio"]))?$_POST["id_folio"]:"";
	$anio = $_POST["anio"];
	$id_estado = $_POST["id_estado"];
	$nombre = $_POST["nombre"];
	$apellidos = $_POST["apellidos"];
	$sexo = $_POST["sexo"];
	$profesion = $_POST["profesion"];
	$matricula = $_POST["matricula"];
	$email = $_POST["email"];
	$celular = $_POST["celular"];
	$nota = $_POST["nota"];

	$msg = $registro_->insert_update($conn, $id_folio, $anio, $id_estado, $nombre, $apellidos, $sexo, $profesion, $matricula, $email, $celular, $nota);

}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $registro_->select($conn, $inicio_p, $TAMANO_PAGINA, "", "");
}

if (isset($_POST['buscar'])){
	$filtro = $_POST["buscarpor"];
	$columna = $_POST["columna"];
	$datos = $registro_->select($conn, $inicio_p, $TAMANO_PAGINA, $filtro, $columna);
}

// Modo cambio en registro
if ($modo=="C" || $modo=="B") {
	$id_folio = (isset($_GET["id_folio"]))?$_GET["id_folio"]:$id_folio;
	$datos = $registro_->obtener($conn, $id_folio);
	//paso datos del GET
	$id_estado = $datos["id_estado"];
	$nombre = $datos["nombre"];
	$apellidos = $datos["apellidos"];
	$sexo = $datos["sexo"];
	$profesion = $datos["profesion"];
	$matricula = $datos["matricula"];
	$email = $datos["email"];
	$celular = $datos["celular"];
	$nota = addslashes(htmlentities($datos["nota"]));
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
	<script src="./js/ckeditor5/ckeditor.js"></script>
	<!-- JS-CSS JAFS -->
	<link rel="stylesheet" href="./css/estilos.css">	
	<script type="text/javascript"><?php require "./js/registros_js.php"; ?></script>
</head>

<body>
	<?php require "menu-nav.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<div class="form-group">
					<label for="agregar"></label>
					<input type="button" name="agregar" value="NUEVO REGISTRO" class="btn btn-info" role="button" id="agregar">
					</div>
					<form method="post" action="registros.php">
						<div class="form-group">
						<input class="text-left" type="text" id="buscarpor" name="buscarpor" value='<?php print $filtro ?>' placeholder="Buscar por..." />
						</div>
						<!-- -->
						<div class="form-group">
						<select class="dropdown" id="columna" name="columna">
							<option value="">-SELECCIONAR-</option>
							<option <?php if($columna=='folio') print 'selected'; ?> value="folio">FOLIO</option>
							<option <?php if($columna=='nombre') print 'selected'; ?> value="nombre">NOMBRE</option>
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
				<h2>Registros <?php print "(".$num.")"; ?></h2>
				<?php
				require "util/mensajes.php";
				if($modo=="A" || $modo=="C" || $modo=="B"){
				?>
				<form class="text-left" action="registros.php" method="post">
					<div class="form-group">
						<label for="id_estado"><b>* E S T A D O :</b></label><br>
						<select <?php if($modo=="B") print 'disabled'; ?> class="dropdown" id="id_estado" name="id_estado" required>
						<option value="">-SELECCIONAR-</option>
						<?php
							for($i = 0; $i<count($combo_estados); $i++){
								$l = $combo_estados[$i]["nombre"];
								print "<option value='";
								print $combo_estados[$i]["id_estado"]."' ";
								if($combo_estados[$i]["id_estado"]==$id_estado) print "selected";
								print ">".$l;
								print "</option>";
							}
						?>						
						</select>
					</div>
					<div class="form-group">
						<label for="nombre"><b>* N O M B R E :</b></label>
						<input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Nombre del asistente"
						value="<?php print $nombre; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="99" />
					</div>
					<div class="form-group">
						<label for="apellidos"><b>* A P E L L I D O (S) :</b></label>
						<input type="text" name="apellidos" id="apellidos" class="form-control" required placeholder="Apellido del asistente" value="<?php print $apellidos; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="99" />
					</div>
					<div class="form-group">
						<label for="sexo"><b>* S E X O :</b></label><br>
						<select <?php if($modo=="B") print 'disabled'; ?> class="dropdown" id="sexo" name="sexo" required >
						<option value="">-SELECCIONAR-</option>
						<option <?php if($sexo==1) print 'selected'; ?> value="1">FEMENINO</option>
						<option <?php if($sexo==2) print 'selected'; ?> value="2">MASCULINO</option>
						</select>
					</div>
					<div class="form-group">
						<label for="profesion"><b>* C A R R E R A / P R O F E S I Ó N :</b></label><br>
						<select class="dropdown" id="profesion" name="profesion" required>
						<option value="">-SELECCIONAR-</option>
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
						<label for="matricula"><b>N D I :</b></label>
						<input type="text" name="matricula" id="matricula" class="form-control" placeholder="Número de identificación o control" value="<?php print $matricula; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="49" />
					</div>					
					<div class="form-group">
						<label for="email"><b>* E - M A I L :</b></label>
						<input type="text" name="email" id="email" class="form-control" required placeholder="E-mail"
						value="<?php print $email; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="99" />
					</div>					
					<div class="form-group">
						<label for="celular"><b>N U M E R O&nbsp;&nbsp;C E L U L A R :</b></label>
						<input type="text" name="celular" id="celular" class="form-control" placeholder="Número de contacto opcional" value="<?php print $celular; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="10" />
					</div>
					<div class="form-group">
						<label for="nota"><b>N O T A :</b></label>
						<textarea name="nota" id="nota" <?php if($modo=="B") print 'disabled'; ?> rows="10" maxlength="499" > <?php print $nota; ?> </textarea>
					</div>															

					<!-- Campos ocultos necesarios: -->
					<input type="hidden" name="id_folio" id="id_folio" value="<?php print $id_folio; ?>" />
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
					print '<th>Folio</th>';
					print '<th>Nombre</th>';
					print '<th>Modificar</th>';
					print '<th>Borrar</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["id_folio"].'</td>';
					print '<td>'.$datos[$i]["nombre"]." ".$datos[$i]["apellidos"].'</td>';
					print '<td><a class="btn btn-info" href="registros.php?modo=C&id_folio='.$datos[$i]["id_folio"].'">M</a></td>';
					print '<td><a class="btn btn-warning" href="registros.php?modo=B&id_folio='.$datos[$i]["id_folio"].'">B</a></td>';
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
        .create( document.querySelector( '#nota' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
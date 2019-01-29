<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/MiPerfil.php";

$perfil = new MiPerfil();

$combo_departamentos = $perfil->combo_departamentos($conn);

$id_usuario = 1;
$datos = $perfil->obtener_registro($conn, $id_usuario);

//paso datos del GET/POST
$id_usuario = $datos["id_usuario"];
$nombre = $datos["nombre"];
$apellidos = $datos["apellidos"];
$id_departamento = $datos["id_departamento"];

$accion = "";

if (isset($_POST["guardar"])){

	$accion = $_POST["guardar"];
	if ($accion=='Guardar'){

		if (isset($_POST["nombre-seg"])){
			$nombre = $_POST["nombre-seg"];
			$apellidos = $_POST["apellidos-seg"];
			$id_departamento = $_POST["select-departamento"];

			$msg = $perfil->act_datos_personales($conn, $id_usuario, $nombre, $apellidos, $id_departamento);
		}

	}
}
 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mi perfil</title>
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
</head>
<body>
<?php require "menu-nav.php" ?>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-d-personales-tab" href="./miperfil.php" role="tab" aria-controls="nav-d-personales" aria-selected="true"><b>Datos personales</b></a>
    <a class="nav-item nav-link" id="nav-d-acceso-tab" href="./miperfil2.php" role="tab" aria-controls="nav-d-acceso" aria-selected="false"><b>Datos accesos</b></a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <?php require "util/mensajes.php"; ?>
  <div class="tab-pane fade show active" id="nav-d-personales" role="tabpanel" aria-labelledby="nav-d-personales-tab">
  	<h2><b><font color="#00802b">Modificar perfil</font></b></h2>
	<form class="text-left" action="miperfil.php" method="post">
		<div class="form-group container-fluid" style="width:80%;" >
			<label for="nombre-seg"><b>* N O M B R E (S) :</b></label>
			<input type="text" name="nombre-seg" id="nombre-seg" class="form-control" placeholder="Nombre de la persona a cargo" value="<?php print $nombre; ?>" required maxlength="99" />
		</div>
		<div class="form-group container-fluid" style="width:80%;" >
			<label for="apellidos-seg"><b>* A P E L L I D O S :</b></label>
			<input type="text" name="apellidos-seg" id="apellidos-seg" class="form-control" placeholder="Apellidos de la persona a cargo" value="<?php print $apellidos; ?>" required maxlength="99" />
		</div>
		<div class="form-group container-fluid" style="width:80%;" >
			<label for="select-departamento"><b>D E P A R T A M E N T O :</b></label><br>
			<select class="dropdown" id="select-departamento" name="select-departamento">
				<option value="">-SELECCIONAR-</option>
				<?php
				for($i = 0; $i<count($combo_departamentos); $i++){
					$l = $combo_departamentos[$i]["nombre"];
					print "<option value='";
					print $combo_departamentos[$i]["id_departamento"]."' ";
					if($combo_departamentos[$i]["id_departamento"]==$id_departamento) print "selected";
					print ">".$l;
					print "</option>";
				}
				?>				
			</select>
		</div>
		<div class="form-group container-fluid" style="width:80%;" >	
		<input type="submit" name="guardar" id="guardar" class="btn btn-success" role="button" value="Guardar"/>
		</div>
	</form>  	
  </div>
</div>
<?php require "footer.php"; ?>
</body>
</html>
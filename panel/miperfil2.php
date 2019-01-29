<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/MiPerfil.php";

$perfil = new MiPerfil();

$id_usuario = 1;
$datos = $perfil->obtener_registro($conn, $id_usuario);

//paso datos del GET/POST
$id_usuario = $datos["id_usuario"];
$usuario = $datos["usuario"];
$contrasena = $datos["contrasena"];

$accion = "";

if (isset($_POST["guardar2"])){

	$accion = $_POST["guardar2"];
	if ($accion=='Guardar'){

		if (isset($_POST["contrasena-seg"])){
			$contrasena = $_POST["contrasena-seg"];
			$contrasena2 = $_POST["contrasena2-seg"];
			$usuario = $_POST["usuario-seg"];

			//$contrasena = substr(hash_hmac("sha512", $contrasena, "keyxyz"),0,50);
			//$contrasena2 = substr(hash_hmac("sha512", $contrasena2, "keyxyz"),0,50);
			if ($contrasena==$contrasena2) {
				$msg = $perfil->act_datos_acceso($conn, $id_usuario, $usuario, $contrasena);
			} else {
				array_push($msg, "2Las contraseñas no coinciden.");
			}

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
    <a class="nav-item nav-link" id="nav-d-personales-tab" href="./miperfil.php" role="tab" aria-controls="nav-d-personales" aria-selected="false"><b>Datos personales</b></a>
    <a class="nav-item nav-link active" id="nav-d-acceso-tab" href="./miperfil2.php" role="tab" aria-controls="nav-d-acceso" aria-selected="true"><b>Datos accesos</b></a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <?php require "util/mensajes.php"; ?>
  <div class="tab-pane fade show active" id="nav-d-acceso" role="tabpanel" aria-labelledby="nav-d-acceso-tab">
  	<h2><b><font color="#00802b">Modificar datos acceso</font></b></h2>
	<form class="text-left" action="miperfil2.php" method="post">
		<div class="form-group container-fluid" style="width:80%;" >
			<label for="usuario-seg"><b>* U S U A R I O :</b></label>
			<input type="text" name="usuario-seg" id="usuario-seg" class="form-control" placeholder="Login de usuario de SEGURIDAD" value="<?php print $usuario; ?>" required maxlength="49" />
		</div>
		<div class="form-group container-fluid" style="width:80%;" >
			<label for="contrasena-seg"><b>* C O N T R A S E Ñ A :</b></label>
			<input type="password" name="contrasena-seg" id="contrasena-seg" class="form-control" placeholder="Nueva contraseña" value="<?php print $contrasena; ?>" required maxlength="49" />
		</div>
		<div class="form-group container-fluid" style="width:80%;" >
			<label for="contrasena2-seg"><b>* R E P E T I R&nbsp;&nbsp;C O N T R A S E Ñ A :</b></label>
			<input type="password" name="contrasena2-seg" id="contrasena2-seg" class="form-control" placeholder="Verificar contraseña" value="<?php print $contrasena; ?>" required maxlength="49" />
		</div>
		<div class="form-group container-fluid" style="width:80%;" >			
		<input type="submit" name="guardar2" id="guardar2" class="btn btn-success" role="button" value="Guardar"/>
		</div>	
	</form>  	
  </div>
</div>
<?php require "footer.php"; ?>
</body>
</html>
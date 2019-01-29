<?php
require "util/conn.php";
require "util/variables_globales.php";
if (isset($_POST["usuario"])){
	$usuario = $_POST["usuario"];
	$contrasena = $_POST["contrasena"];
	$rol_usr = $_POST["rol_usr"];
	// inicio sesion:
	session_start();
	// variable de sesion:
	$_SESSION["login"] = $usuario;
	$_SESSION["rol"] = $rol_usr;
	//$contrasena = substr(hash_hmac("sha512", $contrasena, "keyxyz"), 0,50); //con metodo encriptado
	// consulta usr en BD:
	$sql = "SELECT * FROM usuarios WHERE usuario='".$usuario."' AND contrasena='".$contrasena."'"." AND id_rol=".$rol_usr;
	$r = mysqli_query($conn, $sql);
	$n = mysqli_num_rows($r);
	if($n==1){
		header("location:app.php");
	} else{
		array_push($msg, "2Los datos que ingreso son incorrectos");
		if (isset($_SESSION["login"])) { session_destroy(); }
	}
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>ACCEDER</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico"/>
	<script src="./js/librerias_ui/popper.min.js"></script>
	<!--<script src="./js/librerias_ui/jquery-3.3.1.min.js"></script>-->	<!-- cuando se requiera AJAX -->
	<script src="./js/librerias_ui/jquery-3.3.1.slim.min.js"></script>	
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/librerias_ui/bootstrap.min.js"></script>
</head>

<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<a href="menu.php" class="navbar-brand">
			<img src="./imgs/home.png" width="40" height="40" alt="">
		</a>
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
		<form class="form-inline my-2 my-lg-0">		    	
			<button class="btn btn-outline-info my-2 my-sm-0" type="button" rel="external" onclick="javascript:location.href='../';">
				<img src="./imgs/movil.png" width="40" height="40" alt="">
			</button>
		</form>	
	</nav>
	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav"></div>
			<div class="col-sm-8 text-center">
				</br>
				<img src="./imgs/faviconv.png" width="50" height="50" alt="">
				<h2>R E G I S T R O S</h2>
				<?php require "util/mensajes.php"; ?>
				<form class="text-left" action="index.php" method="post">
					<div class="form-group">
						<label for="usuario"><b>USUARIO:</b></label>
						<input type="text" name="usuario" id="usuario" class="form-control" required placeholder="Ingresar login de usuario" maxlength="49" />
					</div>
					<div class="form-group">
						<label for="contrasena"><b>CONTRASEÑA:</b></label>
						<input type="password" name="contrasena" id="contrasena" class="form-control" required placeholder="Ingresar clave de acceso" maxlength="49" />
					</div>
					<div class="form-group">
						<label for="rol_usr"><b>ROL:</b></label><br>
						<select class="dropdown" id="rol_usr" name="rol_usr" required>
						<option value="">-SELECCIONAR-</option>
						<option value="3">REPORTES</option>
						<option value="2">ADMINISTRACION</option>
						<option value="1">SEGURIDAD</option>
						</select>
					</div>					
					<div class="form-group">
						<label for="entrar"></label>
						<input type="submit" name="entrar" id="entrar" class="btn btn-success" role="button" value="I N G R E S A R" />
					</div>										
				</form>
				<h5>REPORTES: [ usuario = reportes1 ] [ contraseña = x ]</h5>
			</div>
			<div class="col-sm-2 sidenav"></div>
		</div>
	</div>

	<?php require "footer.php"; ?>
</body>
</html>
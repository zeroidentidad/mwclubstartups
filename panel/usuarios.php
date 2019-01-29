<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/Usuarios.php";

$usuario_ = new Usuarios();
$num = $usuario_->numeroRegistros($conn);

$combo_departamentos = $usuario_->combo_departamentos($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"]):
S - Consulta (select)
A - Agregar (insert)
B - Baja (pantalla de confirmacion antes de eliminar)
C - Cambio (update)
D - Baja definitiva (delete)
*/

/** Variables de agregar **/
$id_usuario = "";
$usuario = "";
$contrasena = "";
$nombre = "";
$apellidos = "";
$id_departamento = "";
$id_rol = "";

// Validaciones modos:
if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Delete definitivo
if ($modo=="D") {
	$id_usuario = $_GET["id_usuario"];
	$msg = $usuario_->delete($conn, $id_usuario);
}

// Deteccion insert-update por isset
if (isset($_POST["contrasena"])){
	
	$id_usuario = (isset($_POST["id_usuario"]))?$_POST["id_usuario"]:"";
	$usuario = $_POST["usuario"];
	$contrasena = $_POST["contrasena"];
	$contrasena2 = $_POST["contrasena2"];
	$nombre = $_POST["nombre"];
	$apellidos = $_POST["apellidos"];
	$id_departamento = $_POST["id_departamento"];
	$id_rol = $_POST["id_rol"];
	
	//$contrasena = substr(hash_hmac("sha512", $contrasena, "keyxyz"),0,50); //con metodo encriptado
	//$contrasena2 = substr(hash_hmac("sha512", $contrasena2, "keyxyz"),0,50); //con metodo encriptado

	if ($contrasena==$contrasena2) {
		$msg = $usuario_->insert_update($conn, $id_usuario, $usuario, $contrasena, $nombre, $apellidos, $id_departamento, $id_rol);
	} else {
		array_push($msg, "2Las contraseñas no coinciden.");
		$modo = ($id_usuario=="")?"A":"C";
	}

}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $usuario_->select($conn, $inicio_p, $TAMANO_PAGINA);
}

// Modo cambio en registro
if ($modo=="C" || $modo=="B") {
	$id_usuario = (isset($_GET["id_usuario"]))?$_GET["id_usuario"]:$id_usuario;
	$datos = $usuario_->obtener($conn, $id_usuario);
	//paso datos del GET
	$usuario = $datos["usuario"];
	$contrasena = $datos["contrasena"];
	$nombre = $datos["nombre"];
	$apellidos = $datos["apellidos"];
	$id_departamento = $datos["id_departamento"];
	$id_rol = $datos["id_rol"];	
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Usuarios</title>
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
	<script type="text/javascript"><?php require "./js/usuarios_js.php"; ?></script>
</head>

<body>
	<?php require "menu-nav.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<label for="agregar"></label>
					<input type="button" name="agregar" value="NUEVO USUARIO" class="btn btn-info" role="button" id="agregar">
				<?php } ?>				
			</div>
			<div class="col-sm-8 text-center">
				<h2>Usuarios <?php print "(".$num.")"; ?></h2>
				<?php
				require "util/mensajes.php";
				if($modo=="A" || $modo=="C" || $modo=="B"){
				?>
				<form class="text-left" action="usuarios.php" method="post">
					<div class="form-group">
						<label for="usuario"><b>* U S U A R I O [</b>evitar espacios<b>] :</b></label>
						<input type="text" name="usuario" id="usuario" class="form-control" required placeholder="El nombre de usuario (login), sin espacios" value="<?php print $usuario; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="49" />
					</div>
					<div class="form-group">
						<label for="contrasena"><b>* C O N T R A S E Ñ A :</b></label>
						<input type="password" name="contrasena" id="contrasena" class="form-control" required placeholder="Contraseña de acceso" <?php if($modo=="B") print 'disabled'; ?> maxlength="49" value="<?php print $contrasena; ?>" />
					</div>
					<div class="form-group">
						<label for="contrasena2"><b>* R E P E T I R&nbsp;&nbsp;C O N T R A S E Ñ A :</b></label>
						<input type="password" name="contrasena2" id="contrasena2" class="form-control" required placeholder="Verifica contraseña de acceso" <?php if($modo=="B") print 'disabled'; ?> maxlength="49" value="<?php print $contrasena; ?>" />
					</div>
					<div class="form-group">
						<label for="nombre"><b>* N O M B R E (S) :</b></label>
						<input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Nombre real de la persona"
						value="<?php print $nombre; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="99" />
					</div>
					<div class="form-group">
						<label for="apellidos"><b>* A P E L L I D O S :</b></label>
						<input type="text" name="apellidos" id="apellidos" class="form-control" required placeholder="Apellidos de la persona"
						value="<?php print $apellidos; ?>" <?php if($modo=="B") print 'disabled'; ?> maxlength="99" />
					</div>
					<div class="form-group">
						<label for="id_departamento"><b>D E P A R T A M E N T O :</b></label><br>
						<select class="dropdown" id="id_departamento" name="id_departamento">
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
					<div class="form-group">
						<label for="id_rol"><b>* R O L :</b></label><br>
						<select class="dropdown" id="id_rol" name="id_rol" required>
						<option value="">-SELECCIONAR-</option>
						<option <?php if($id_rol==3) print 'selected'; ?> value="3">REPORTES</option>
						<option <?php if($id_rol==2) print 'selected'; ?> value="2">ADMINISTRACION</option>
						</select>
					</div>																

					<!-- Campos ocultos necesarios: -->
					<input type="hidden" name="id_usuario" id="id_usuario" value="<?php print $id_usuario; ?>" />
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
					print '<th>Usuario</th>';
					print '<th>Modificar</th>';
					print '<th>Borrar</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["usuario"].'</td>';
					print '<td><a class="btn btn-info" href="usuarios.php?modo=C&id_usuario='.$datos[$i]["id_usuario"].'">M</a></td>';
					print '<td><a class="btn btn-warning" href="usuarios.php?modo=B&id_usuario='.$datos[$i]["id_usuario"].'">B</a></td>';
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
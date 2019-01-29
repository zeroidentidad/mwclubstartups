<?php
require "./panel/util/conn.php";
require "./util/variables_globales.php";
require "./clases/FormularioMovil.php";

$registro = new FormularioMovil();

$combo_estados = $registro->combo_estados($conn);

$combo_profesiones = $registro->combo_profesiones($conn);

/** Variables nuevo registro **/
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

if (isset($_POST["selectEstado"])){
	//
	$id_folio = (isset($_POST["id_folio"]))?$_POST["id_folio"]:"";
	$anio = $_POST["anio"];
	$id_estado = $_POST["selectEstado"];
	$nombre = $_POST["nombre"];
	$apellidos = $_POST["apellido"];
	$sexo = $_POST["selectSexo"];
	$profesion = $_POST["selectProfesion"];
	$matricula = $_POST["matricula"];
	$email = $_POST["email"];
	$celular = $_POST["celular"];
	$nota = $_POST["nota"];
	//
	if ($id_estado=="") {
		array_push($msg, "2ESTADO es requerido");
	} else if($nombre==""){
		array_push($msg, "2NOMBRE es requerido");
	} else if($apellidos==""){
		array_push($msg, "2APELLIDO(S) es requerido");
	} else if($sexo==""){
		array_push($msg, "2SEXO es requerido");
	} else if($profesion==""){
		array_push($msg, "2PROFESION es requerido");
	}else if($email==""){
		array_push($msg, "2E-MAIL es requerido");
	}	
	else {
	$msg = $registro->insertar($conn, $id_folio, $anio, $id_estado, $nombre, $apellidos, $sexo, $profesion, $matricula, $email, $celular, $nota);
	}
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
	<script> $(document).bind("mobileinit", function(){ $.extend( $.mobile , { ajaxEnabled: false }); }); </script>
	<script src="./js/jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
	<script src="./js/manipulacion_ui.js?v=<?php echo(rand()); ?>"></script>
</head>
<body>
<div data-role="page" id="divRegistro" data-theme="a">	
	<div data-role="header" id="divHeader">
		<a href="./" class="ui-btn-left" rel="external"><b>LISTA CONTACTOS</b></a>
		<h1>[ + ]:</h1>
		<a href="./panel/" class="ui-btn-right" rel="external"><b>PANEL PC</b></a>
	</div>
	<div data-role="content" id="divContent">
		<label><b>Los campos con <font color="#ff0000">*</font> son obligarios.</b></label>
		<?php require "./util/mensajes.php"; ?>
		<form method="post" data-ajax="false" id="formRegistro">
				<!-- Campos ocultos necesarios: -->
				<div data-role="fieldcontain" id="divId_folio">
					<input type="hidden" name="id_folio" id="id_folio"/>
				</div>	
				<div data-role="fieldcontain" id="divAnio">	
					<input type="hidden" name="anio" id="anio" value="<?php print date("Y"); ?>"/>
				</div>	
				<!-- -------------------------- -->

				<div data-role="fieldcontain" id="divselectEstado">
					<select name="selectEstado" id="selectEstado">
						<option value="">* SELECCIONAR ESTADO</option>
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

				<div data-role="fieldcontain" id="divNombre">	
					<input type="text" data-clear-btn="true" name="nombre" id="nombre" placeholder="* N O M B R E (S)" maxlength="99"/>
				</div>

				<div data-role="fieldcontain" id="divApellidos">
					<input type="text" data-clear-btn="true" name="apellido" id="apellido" placeholder="* A P E L L I D O (S)" maxlength="99"/>
				</div>					

				<div data-role="fieldcontain" id="divselectSexo">
					<select name="selectSexo" id="selectSexo">
						<option value="">* SELECCIONAR SEXO</option>
						<option value="1">FEMENINO</option>
						<option value="2">MASCULINO</option>
					</select>
				</div>

				<div data-role="fieldcontain" id="divselectProfesion">
					<select name="selectProfesion" id="selectProfesion">
						<option value="">* SELECCIONAR PROFESIÓN</option>
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

				<div data-role="fieldcontain" id="divMatricula">
					<input type="text" data-clear-btn="true" name="matricula" id="matricula" placeholder=" N D I" maxlength="49"/>
				</div>	

				<div data-role="fieldcontain" id="divEmail">
					<input type="text" data-clear-btn="true" name="email" id="email" placeholder="* E - M A I L" maxlength="99"/>
				</div>

				<div data-role="fieldcontain" id="divCel">
					<input type="text" data-clear-btn="true" name="celular" id="celular" placeholder=" N U M E R O  C E L U L A R" maxlength="10"/>
				</div>

				<div data-role="fieldcontain" id="divNota">
					<textarea name="nota" id="nota" placeholder=" N O T A   E M P R E N D I M I E N T O" maxlength="499"></textarea>
				</div>		

				<input type="submit" name="registrar" id="registrar" class="ui-btn ui-btn-b" value="Registrar"/>
				<br>
				<div data-role="footer">
					<h1><a href="http://softcun.co.nf"><font color="#00802b">Hecho por <b>Jesus A. Ferrer S.</b></font></a></h1>
				</div>
		</form>
	</div>
</div>	
</body>
</html>
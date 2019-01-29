<?php
/***/
class MiPerfil {

	public function obtener_registro($conn, $id_usuario){
		$datos = "1Error al obtener el registro.";
		$sql = "SELECT * FROM usuarios WHERE id_usuario=".$id_usuario; //." AND usuario='adminseg'"
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function act_datos_personales($conn, $id_usuario, $nombre, $apellidos, $departamento){

		$msg = array();

		if ($nombre=="") {
			array_push($msg, "1El nombre de la persona a cargo es requerido.");
		} else if($apellidos==""){
			array_push($msg, "1El apellido de la persona a cargo es requerido.");
		} else {

				$sql = "UPDATE usuarios SET ";
				$sql.= "nombre='".$nombre."', ";
				$sql.= "apellidos='".$apellidos."', ";
				$sql.= "id_departamento='".$departamento."' ";			
				$sql.= "WHERE id_usuario=".$id_usuario;

			if (mysqli_query($conn, $sql)) {
				array_push($msg, "0Guardado correcto.");
			}else{
				array_push($msg, "1Error en el guardado.");
			}

			return $msg;
		}
	}

	public function act_datos_acceso($conn, $id_usuario, $usuario, $contrasena){

		$msg = array();

		if ($contrasena=="") {
			array_push($msg, "1La contraseña del usuario es requerida.");
		} else if($usuario==""){
			array_push($msg, "1El nombre (login) de usuario es requerido.");
		} else {

				$sql = "UPDATE usuarios SET ";
				$sql.= "usuario='".$usuario."', ";
				$sql.= "contrasena='".$contrasena."' ";				
				$sql.= "WHERE id_usuario=".$id_usuario;				

			if (mysqli_query($conn, $sql)) {
				array_push($msg, "0Guardado correcto.");
			}else{
				array_push($msg, "1Error en el guardado.");
			}

			return $msg;
		}
	}

	/* Funciones data COMBOS: */

	public function combo_departamentos($conn){
		$sql = "SELECT * FROM cat_departamentos";
		$sql.= " ORDER BY nombre";
		$r = mysqli_query($conn, $sql);
		$arreglo = array();

		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				array_push($arreglo, $row);
			}
		}

		return $arreglo;
	}		

}

?>
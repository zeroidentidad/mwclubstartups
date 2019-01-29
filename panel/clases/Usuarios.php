<?php
/***/
class Usuarios {

	public function select($conn, $inicio="", $maximo=""){
		$sql = "SELECT * FROM usuarios WHERE id_usuario!=1 ORDER BY usuario";
		if($inicio!=="" && $maximo!==""){
			$sql.= " LIMIT ".$inicio.", ".$maximo;
		}
		$r = mysqli_query($conn, $sql);
		$arreglo = array();

		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				array_push($arreglo, $row);
			}
		}

		return $arreglo;
	}

	public function numeroRegistros($conn){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM usuarios WHERE id_usuario!=1";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	public function delete($conn, $id_usuario){
		$sql = "DELETE FROM usuarios WHERE id_usuario=".$id_usuario;

		if (mysqli_query($conn, $sql)) {
			header("location:usuarios.php");
			}
		$msg = array("1Error al eliminar el registro.");

		return $msg;
	}

	public function obtener($conn, $id_usuario){
		$datos = "1Error al obtener el registro.";
		$sql = "SELECT * FROM usuarios WHERE id_usuario=".$id_usuario;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function insert_update($conn, $id_usuario, $usuario, $contrasena, $nombre, $apellidos, $id_departamento, $id_rol){
		$msg = array();

		if ($contrasena=="") {
			array_push($msg, "2La contraseña del usuario es requerida.");
		} else if($usuario==""){
			array_push($msg, "2El nombre (login) de usuario es requerido.");
		} else if($nombre==""){
			array_push($msg, "2El nombre real es requerido.");
		} else if($apellidos==""){
			array_push($msg, "2El apellido es requerido.");
		} else if($id_rol==""){
			array_push($msg, "2El rol es requerido.");
		} else {
			if ($id_usuario=="") {
				$sql = "INSERT INTO usuarios VALUES(0,";
				$sql.= "'".$usuario."', ";
				$sql.= "'".$contrasena."', ";
				$sql.= "'".$nombre."', ";
				$sql.= "'".$apellidos."', ";
				$sql.= "'".$id_departamento."', ";
				$sql.= "'".$id_rol."')";
			}else{
				$sql = "UPDATE usuarios SET ";
				$sql.= "usuario='".$usuario."', ";
				$sql.= "contrasena='".$contrasena."', ";
				$sql.= "nombre='".$nombre."', ";
				$sql.= "apellidos='".$apellidos."', ";
				$sql.= "id_departamento='".$id_departamento."', ";
				$sql.= "id_rol='".$id_rol."' ";				
				$sql.= "WHERE id_usuario=".$id_usuario;				
			}

			if (mysqli_query($conn, $sql)) {
				array_push($msg, "0Guardado correcto.");
			}else{
				
				if (mysqli_errno($conn)==1062){
					array_push($msg, "1No duplicar: Este usuario ya existe. Elige un nombre de usuario diferente.");
				}
				else if(mysqli_errno($conn)==1040){
					array_push($msg, "2Demasiadas conexiones: La configuración del servidor de base de datos no soporta la cantidad de conexiones actuales.");
				}			
				else{
					array_push($msg, "1Error en el guardado. Recargar e intentar nuevamente. </br>Error ".mysqli_errno($conn).": ".mysqli_error($conn));					
				}

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
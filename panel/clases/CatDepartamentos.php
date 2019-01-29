<?php
/***/
class CatDepartamentos {

	public function select($conn, $inicio="", $maximo=""){
		$sql = "SELECT * FROM cat_departamentos ORDER BY nombre";
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
		$sql = "SELECT COUNT(*) AS num FROM cat_departamentos";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	public function delete($conn, $id_departamento){
		$sql = "DELETE FROM cat_departamentos WHERE id_departamento=".$id_departamento;

		if (mysqli_query($conn, $sql)) {
			header("location:cat_departamentos.php");
			}
		$msg = array("1Error al eliminar el registro.");

		return $msg;
	}

	public function obtener($conn, $id_departamento){
		$datos = "1Error al obtener el registro.";
		$sql = "SELECT * FROM cat_departamentos WHERE id_departamento=".$id_departamento;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function insert_update($conn, $id_departamento, $nombre){
		$msg = array();

		if ($nombre=="") {
			array_push($msg, "2El nombre es requerido.");
		} else {
			if ($id_departamento=="") {
				$sql = "INSERT INTO cat_departamentos VALUES(0,";
				$sql.= "'".$nombre."')";
			}else{
				$sql = "UPDATE cat_departamentos SET ";
				$sql.= "nombre='".$nombre."' ";			
				$sql.= "WHERE id_departamento=".$id_departamento;				
			}

			if (mysqli_query($conn, $sql)) {
				array_push($msg, "0Guardado correcto.");
			}else{
				
				if (mysqli_errno($conn)==1062){
					array_push($msg, "1No duplicar: Este departamento ya existe. Elige un nombre de departamento diferente.");
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

}

?>
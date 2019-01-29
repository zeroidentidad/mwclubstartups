<?php
/***/
class CatProfesiones {

	public function select($conn, $inicio="", $maximo=""){
		$sql = "SELECT * FROM cat_profesiones ORDER BY nombre";
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
		$sql = "SELECT COUNT(*) AS num FROM cat_profesiones";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	public function delete($conn, $id_profesion){
		$sql = "DELETE FROM cat_profesiones WHERE id_profesion=".$id_profesion;

		if (mysqli_query($conn, $sql)) {
			header("location:cat_profesiones.php");
			}
		$msg = array("1Error al eliminar el registro.");

		return $msg;
	}

	public function obtener($conn, $id_profesion){
		$datos = "1Error al obtener el registro.";
		$sql = "SELECT * FROM cat_profesiones WHERE id_profesion=".$id_profesion;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function insert_update($conn, $id_profesion, $nombre){
		$msg = array();

		if ($nombre=="") {
			array_push($msg, "2El nombre es requerido.");
		} else {
			if ($id_profesion=="") {
				$sql = "INSERT INTO cat_profesiones VALUES(0,";
				$sql.= "'".$nombre."')";
			}else{
				$sql = "UPDATE cat_profesiones SET ";
				$sql.= "nombre='".$nombre."' ";			
				$sql.= "WHERE id_profesion=".$id_profesion;				
			}

			if (mysqli_query($conn, $sql)) {
				array_push($msg, "0Guardado correcto.");
			}else{
				
				if (mysqli_errno($conn)==1062){
					array_push($msg, "1No duplicar: Esta profesión ya existe. Elige un nombre de profesión diferente.");
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
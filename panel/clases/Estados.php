<?php
/***/
class Estados {

	public function select($conn, $inicio="", $maximo="", $filtro="", $columna=""){
		$sql = "SELECT * FROM estados";
		if($filtro!==""){
			if ($columna=="id_estado") {
				$sql.= " WHERE id_estado=".$filtro." AND anio=".date("Y");
			} else if($columna=="nombre"){
				$sql.= " WHERE nombre LIKE '%".$filtro."%' AND anio=".date("Y");
			}
		} else {$sql.= " WHERE anio=".date("Y");}
		$sql.= " ORDER BY id_estado";
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
		$sql = "SELECT COUNT(*) AS num FROM estados WHERE anio=".date("Y");
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	public function delete($conn, $id_estado){
		$sql = "DELETE FROM estados WHERE id_estado=".$id_estado;

		if (mysqli_query($conn, $sql)) {
			header("location:estados.php");
			}
		$msg = array("1Error al eliminar el registro.");

		return $msg;
	}

	public function obtener($conn, $id_estado){
		$datos = "1Error al obtener el registro.";
		$sql = "SELECT * FROM estados WHERE id_estado=".$id_estado;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function insert_update($conn, $id_estado, $anio, $nombre, $pais, $estatus, $descripcion){
		$msg = array();

		if ($nombre=="") {
			array_push($msg, "2El nombre del evento es requerido.");
		} else if($pais==""){
			array_push($msg, "2El pais del estado es requerido.");
		} else if($estatus==""){
			array_push($msg, "2El estatus es requerido.");
		} else {
			if ($id_estado=="") {
				$sql = "INSERT INTO estados VALUES(0,";
				$sql.= "'".$anio."', ";
				$sql.= "'".$nombre."', ";
				$sql.= "'".$pais."', ";
				$sql.= "'".$estatus."', ";
				$sql.= "'".$descripcion."')";
			}else{
				$sql = "UPDATE estados SET ";
				$sql.= "nombre='".$nombre."', ";
				$sql.= "pais='".$pais."', ";
				$sql.= "estatus='".$estatus."', ";
				$sql.= "descripcion='".$descripcion."' ";				
				$sql.= "WHERE id_estado=".$id_estado;				
			}

			if (mysqli_query($conn, $sql)) {
				array_push($msg, "0Guardado correcto.");
			}else{
				
				if(mysqli_errno($conn)==1040){
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
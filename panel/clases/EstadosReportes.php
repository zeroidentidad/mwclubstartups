<?php
/***/
class EstadosReportes {

	public function select($conn, $inicio="", $maximo=""){
		$sql = "SELECT * FROM estados WHERE anio=".date("Y")." ORDER BY nombre ASC";
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

	/* Funciones de reportes: */

	public function numeroRegistrosReporte($conn, $anio, $pais){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM estados e";
		$sql.= " WHERE e.anio=".$anio;
		if($pais!==""){
		$sql.= " AND e.pais LIKE '".$pais."'";
		}		
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}

	public function select_estados($conn, $anio, $pais){
		$datos = "1Error al obtener los estados";
		$sql = "SELECT e.*";
		$sql.= " FROM estados e WHERE e.anio=".$anio;
		if($pais!==""){
		$sql.= " AND e.pais LIKE '".$pais."'";
		}
		$sql.= " ORDER BY e.pais";
		$r = mysqli_query($conn, $sql);
		$salida = array();
		if ($r) {
			while($row = mysqli_fetch_assoc($r)){
				array_push($salida, $row);
			}
		}
		return $salida;
	}

	public function select_estado($conn, $id_estado){
		$salida = "1Error al obtener el estado";
		$sql = "SELECT e.*";
		$sql.= " FROM estados e WHERE e.id_estado=".$id_estado;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$salida = mysqli_fetch_assoc($r);
		}
		return $salida;
	}

}

?>
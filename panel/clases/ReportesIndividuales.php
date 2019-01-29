<?php
/***/
class ReportesIndividuales {

	public function select($conn, $inicio="", $maximo="", $filtro="", $columna=""){
		$sql = "SELECT * FROM contactos";
		if($filtro!==""){
			if ($columna=="folio") {
				$sql.= " WHERE id_folio=".$filtro;
			} else if($columna=="nombre"){
				$sql.= " WHERE CONCAT_WS (' ', nombre, apellidos) LIKE UPPER('%".$filtro."%')";
			} else if($columna=="matricula"){
				$sql.= " WHERE matricula LIKE '%".$filtro."%'";
			}			
		}
		$sql.= " ORDER BY id_folio";
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
		$sql = "SELECT COUNT(*) AS num FROM contactos";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	/* Funciones de reportes: */

	public function numeroRegistrosReporte($conn, $id_folio){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM contactos a";
		$sql.= " WHERE id_folio=".$id_folio;		
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}

	public function select_contacto($conn, $id_folio){
		$salida = "1Error al obtener el registro";

		//mysqli_query($conn, "SET lc_time_names = 'es_ES';");
		$sql = "SELECT a.*,";
		$sql.= " (SELECT e.nombre FROM estados e WHERE e.id_estado=a.id_estado) AS estado_descripcion,";
		$sql.= " (SELECT e.pais FROM estados e WHERE e.id_estado=a.id_estado) AS pais_estado,";
		$sql.= " CASE WHEN a.sexo=1 THEN 'FEMENINO' WHEN a.sexo=2 THEN 'MASCULINO' END AS sexo_descripcion,";
		$sql.= " (SELECT cp.nombre FROM cat_profesiones cp WHERE cp.id_profesion=a.profesion) AS profesion_descripcion";
		$sql.= " FROM contactos a WHERE a.id_folio=".$id_folio;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$salida = mysqli_fetch_assoc($r);
		}
		return $salida;
	}

}

?>
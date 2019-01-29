<?php
/***/
class ReportesMasivos {

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

	/* Funciones data COMBOS: */	

	public function combo_profesiones($conn){
		$sql = "SELECT * FROM cat_profesiones";
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

	public function combo_anios($conn){
		$sql = "SELECT DISTINCT anio FROM contactos";
		$sql.= " ORDER BY anio DESC";
		$r = mysqli_query($conn, $sql);
		$arreglo = array();

		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				array_push($arreglo, $row);
			}
		}

		return $arreglo;
	}

	/* Funciones de reportes: */

	public function numeroRegistrosReporte($conn, $anio="", $estado="", $sexo="", $profesion=""){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM contactos a";
		$sql.= " WHERE";
		$sql.= " a.anio=".$anio;
		if ($estado!==""){
		$sql.= " AND a.id_estado=".$estado;
		}		
		if ($sexo!==""){
		$sql.= " AND a.sexo=".$sexo;
		}
		if ($profesion!==""){
		$sql.= " AND a.profesion=".$profesion;
		}
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}

	public function select_contactos($conn, $anio="", $estado="", $sexo="", $profesion=""){
		$salida = "1Error al obtener el registro";

		$sql = "SELECT a.*,";
		$sql.= " CASE WHEN a.sexo=1 THEN 'FEMENINO' WHEN a.sexo=2 THEN 'MASCULINO' END AS sexo_descripcion,";
		$sql.= " (SELECT cp.nombre FROM cat_profesiones cp WHERE cp.id_profesion=a.profesion) AS profesion_descripcion,";
		$sql.= " (SELECT es.nombre FROM estados es WHERE es.id_estado=a.id_estado) AS estado_descripcion";
		$sql.= " FROM contactos a";
		$sql.= " WHERE";
		$sql.= " a.anio=".$anio;
		if ($estado!==""){
		$sql.= " AND a.id_estado=".$estado;
		}		
		if ($sexo!==""){
		$sql.= " AND a.sexo=".$sexo;
		}
		if ($profesion!==""){
		$sql.= " AND a.profesion=".$profesion;
		}
		$sql.= " ORDER BY a.id_folio ASC";
		$r = mysqli_query($conn, $sql);
		$salida = array();
		if ($r) {
			while($row = mysqli_fetch_assoc($r)){
				array_push($salida, $row);
			}
		}
		return $salida;
	}

	public function select_profesion($conn, $profesion){
		$datos = "1Error al obtener el registro.";
		$sql = "SELECT * FROM cat_profesiones WHERE id_profesion=".$profesion;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

}

?>
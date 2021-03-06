<?php
/***/
class ListadoMovil {

	public function select($conn, $inicio="", $maximo=""){
		$sql = "SELECT a.*,";
		$sql.= " (SELECT cp.nombre FROM cat_profesiones cp WHERE cp.id_profesion=a.profesion) AS profesion_descripcion,";
		$sql.= " (SELECT es.nombre FROM estados es WHERE es.id_estado=a.id_estado) AS estado_descripcion";
		$sql.= " FROM contactos a";		
		$sql.= " ORDER BY estado_descripcion ASC";
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

}

?>
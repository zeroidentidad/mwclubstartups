<?php
/***/
class ReportesConsultas {

	public function select($conn, $inicio="", $maximo="", $anio="", $folio="", $nombre="", $apellidos="", $sexo="", $profesion="", $matricula="", $email="", $celular="", $nota=""){
		$sql = "SELECT a.*,";
		$sql.= " SUBSTRING(a.nota,1,15) AS nota_fragmento,";
		$sql.= " CASE WHEN a.sexo=1 THEN 'FEMENINO' WHEN a.sexo=2 THEN 'MASCULINO' END AS sexo_descripcion,";
		$sql.= " (SELECT cp.nombre FROM cat_profesiones cp WHERE cp.id_profesion=a.profesion) AS profesion_descripcion,";
		$sql.= " (SELECT e.nombre FROM estados e WHERE e.id_estado=a.id_estado) AS estado_descripcion";
		$sql.= " FROM contactos a";
		$sql.= " WHERE";
		$sql.= " a.anio=(CASE WHEN '".$anio."'='' THEN a.anio ELSE '".$anio."' END)";
		$sql.= " AND a.id_folio=(CASE WHEN '".$folio."'='' THEN a.id_folio ELSE '".$folio."' END)";
		$sql.= " AND a.nombre LIKE (CASE WHEN '".$nombre."'='' THEN a.nombre ELSE '%".$nombre."%' END)";
		$sql.= " AND a.apellidos LIKE (CASE WHEN '".$apellidos."'='' THEN a.apellidos ELSE '%".$apellidos."%' END)";
		$sql.= " AND a.sexo=(CASE WHEN '".$sexo."'='' THEN a.sexo ELSE '".$sexo."' END)";
		$sql.= " AND a.profesion=(CASE WHEN '".$profesion."'='' THEN a.profesion ELSE '".$profesion."' END)";
		$sql.= " AND a.matricula LIKE (CASE WHEN '".$matricula."'='' THEN a.matricula ELSE '%".$matricula."%' END)";
		$sql.= " AND a.email LIKE (CASE WHEN '".$email."'='' THEN a.email ELSE '%".$email."%' END)";
		$sql.= " AND a.celular LIKE (CASE WHEN '".$celular."'='' THEN a.celular ELSE '%".$celular."%' END)";
		$sql.= " AND a.nota LIKE (CASE WHEN '".$nota."'='' THEN a.nota ELSE '%".$nota."%' END)";
		$sql.= " ORDER BY a.id_folio DESC";
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

	public function numeroRegistrosReporte($conn, $anio="", $folio="", $nombre="", $apellidos="", $sexo="", $profesion="", $matricula="", $email="", $celular="", $nota=""){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM contactos a";
		$sql.= " WHERE";
		$sql.= " a.anio=(CASE WHEN '".$anio."'='' THEN a.anio ELSE '".$anio."' END)";
		$sql.= " AND a.id_folio=(CASE WHEN '".$folio."'='' THEN a.id_folio ELSE '".$folio."' END)";
		$sql.= " AND a.nombre LIKE (CASE WHEN '".$nombre."'='' THEN a.nombre ELSE '%".$nombre."%' END)";
		$sql.= " AND a.apellidos LIKE (CASE WHEN '".$apellidos."'='' THEN a.apellidos ELSE '%".$apellidos."%' END)";
		$sql.= " AND a.sexo=(CASE WHEN '".$sexo."'='' THEN a.sexo ELSE '".$sexo."' END)";
		$sql.= " AND a.profesion=(CASE WHEN '".$profesion."'='' THEN a.profesion ELSE '".$profesion."' END)";
		$sql.= " AND a.matricula LIKE (CASE WHEN '".$matricula."'='' THEN a.matricula ELSE '%".$matricula."%' END)";
		$sql.= " AND a.email LIKE (CASE WHEN '".$email."'='' THEN a.email ELSE '%".$email."%' END)";
		$sql.= " AND a.celular LIKE (CASE WHEN '".$celular."'='' THEN a.celular ELSE '%".$celular."%' END)";
		$sql.= " AND a.nota LIKE (CASE WHEN '".$nota."'='' THEN a.nota ELSE '%".$nota."%' END)";	
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}

	public function select_contactos($conn, $anio="", $folio="", $nombre="", $apellidos="", $sexo="", $profesion="", $matricula="", $email="", $celular="", $nota=""){
		$salida = "1Error al obtener el registro";

		//mysqli_query($conn, "SET lc_time_names = 'es_ES';");

		$sql = "SELECT a.*,";
		$sql.= " CASE WHEN a.sexo=1 THEN 'FEMENINO' WHEN a.sexo=2 THEN 'MASCULINO' END AS sexo_descripcion,";
		$sql.= " (SELECT cp.nombre FROM cat_profesiones cp WHERE cp.id_profesion=a.profesion) AS profesion_descripcion,";
		$sql.= " (SELECT e.nombre FROM estados e WHERE e.id_estado=a.id_estado) AS estado_descripcion";
		$sql.= " FROM contactos a";
		$sql.= " WHERE";
		$sql.= " a.anio=(CASE WHEN '".$anio."'='' THEN a.anio ELSE '".$anio."' END)";
		$sql.= " AND a.id_folio=(CASE WHEN '".$folio."'='' THEN a.id_folio ELSE '".$folio."' END)";
		$sql.= " AND a.nombre LIKE (CASE WHEN '".$nombre."'='' THEN a.nombre ELSE '%".$nombre."%' END)";
		$sql.= " AND a.apellidos LIKE (CASE WHEN '".$apellidos."'='' THEN a.apellidos ELSE '%".$apellidos."%' END)";
		$sql.= " AND a.sexo=(CASE WHEN '".$sexo."'='' THEN a.sexo ELSE '".$sexo."' END)";
		$sql.= " AND a.profesion=(CASE WHEN '".$profesion."'='' THEN a.profesion ELSE '".$profesion."' END)";
		$sql.= " AND a.matricula LIKE (CASE WHEN '".$matricula."'='' THEN a.matricula ELSE '%".$matricula."%' END)";
		$sql.= " AND a.email LIKE (CASE WHEN '".$email."'='' THEN a.email ELSE '%".$email."%' END)";
		$sql.= " AND a.celular LIKE (CASE WHEN '".$celular."'='' THEN a.celular ELSE '%".$celular."%' END)";
		$sql.= " AND a.nota LIKE (CASE WHEN '".$nota."'='' THEN a.nota ELSE '%".$nota."%' END)";
		$sql.= " ORDER BY a.id_folio DESC";
		$r = mysqli_query($conn, $sql);
		$salida = array();
		if ($r) {
			while($row = mysqli_fetch_assoc($r)){
				array_push($salida, $row);
			}
		}
		return $salida;
	}

}

?>
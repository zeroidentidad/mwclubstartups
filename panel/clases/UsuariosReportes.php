<?php
/***/
class UsuariosReportes {

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

	/* Funciones de reportes: */
	public function select_usuarios($conn){
		$datos = "1Error al obtener los usuarios";
		$sql = "SELECT u.id_usuario, u.usuario, u.contrasena, u.nombre, u.apellidos,";
		$sql.= " IF(u.id_departamento=0, 'NO ASIGNADO',";
		$sql.= "(SELECT cd.nombre FROM cat_departamentos cd WHERE cd.id_departamento=u.id_departamento)) AS id_departamento,";
		$sql.= " CASE WHEN u.id_rol=2 THEN 'ADMINISTRACION' WHEN u.id_rol=3 THEN 'REPORTES' END AS id_rol";

		$sql.= " FROM usuarios u WHERE u.id_usuario!=1 ORDER BY u.usuario";
		$r = mysqli_query($conn, $sql);
		$salida = array();
		if ($r) {
			while($row = mysqli_fetch_assoc($r)){
				array_push($salida, $row);
			}
		}
		return $salida;
	}

	public function select_usuario($conn, $id_usuario){
		$salida = "1Error al obtener el usuario";
		$sql = "SELECT u.id_usuario, u.usuario, u.contrasena, u.nombre, u.apellidos,";
		$sql.= " IF(u.id_departamento=0, 'NO ASIGNADO',";
		$sql.= "(SELECT cd.nombre FROM cat_departamentos cd WHERE cd.id_departamento=u.id_departamento)) AS id_departamento,";
		$sql.= " CASE WHEN u.id_rol=2 THEN 'ADMINISTRACION' WHEN u.id_rol=3 THEN 'REPORTES' END AS id_rol";

		$sql.= " FROM usuarios u WHERE u.id_usuario=".$id_usuario;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$salida = mysqli_fetch_assoc($r);
		}
		return $salida;
	}

}

?>
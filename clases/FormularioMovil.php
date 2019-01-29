<?php

class FormularioMovil {

	public function insertar($conn, $id_folio, $anio, $id_estado, $nombre, $apellidos, $sexo, $profesion, $matricula, $email, $celular, $nota){
		$msg = array();

			if ($id_folio=="") {
				$sql = "INSERT INTO contactos VALUES(0,";
				$sql.= $anio.", ";
				$sql.= $id_estado.", ";
				$sql.= "UPPER('".$nombre."'), ";
				$sql.= "UPPER('".$apellidos."'), ";
				$sql.= $sexo.", ";
				$sql.= $profesion.", ";
				$sql.= "'".$matricula."', ";
				$sql.= "'".$email."', ";
				$sql.= "'".$celular."', ";
				$sql.= "'".$nota."')";
			}else{
				$sql = "UPDATE contactos SET ";
				$sql.= "id_estado='".$id_estado."', ";
				$sql.= "nombre='".$nombre."', ";				
				$sql.= "apellidos='".$apellidos."', ";				
				$sql.= "sexo='".$sexo."', ";			
				$sql.= "profesion='".$profesion."', ";		
				$sql.= "matricula='".$matricula."', ";	
				$sql.= "email='".$email."', ";
				$sql.= "celular='".$celular."', ";
				$sql.= "nota='".$nota."' ";
				$sql.= "WHERE id_folio=".$id_folio;				
			}

			if (mysqli_query($conn, $sql)) {
				array_push($msg, "0Resgistrado correctamente. FOLIO: ".mysqli_insert_id($conn)." </br>[Para feedback-modificación mi núm es +52 9141239545]");
			}else{

				if (mysqli_errno($conn)==1062){
					array_push($msg, "1No duplicar: Este registro ya existe. Considera registrarte con otro e-mail.");
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

	/* Funciones data COMBOS: */

	public function combo_estados($conn){
		$sql = "SELECT * FROM estados";
		$sql.= " WHERE estatus=1";
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
		

}

?>
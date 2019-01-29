window.onload = function(){
	document.getElementById("rpt_anual").onclick = function (){
		var vanio = $('#anio').val();
		if(vanio!=""){ window.open("./reportes/registros_anuales_rpt.php?anio="+vanio, "_self"); } else { alert("\nSELECCIONAR AÑO :("); }	
	}
	document.getElementById("rpt_estado").onclick = function (){
		var vanio = $('#anio').val();
		var vestado = $('#estado').val();
		if(vanio!=""&&vestado!=""){ window.open("./reportes/registros_estados_rpt.php?anio="+vanio+"&estado="+vestado, "_self"); } else { alert("\nSELECCIONAR AÑO + ESTADO :("); }
	}
	/* RPTs por SEXO: */	
	document.getElementById("sexo_anual").onclick = function (){
		var vanio = $('#anio').val();
		var vsexo = $('#sexo').val();
		if(vanio!=""&&vsexo!=""){ window.open("./reportes/registros_sexo_rpt.php?anio="+vanio+"&sexo="+vsexo+"&tr=1", "_self"); } else { alert("\nSELECCIONAR AÑO + SEXO :("); }
	}
	document.getElementById("sexo_estado").onclick = function (){
		var vanio = $('#anio').val();
		var vestado = $('#estado').val();
		var vsexo = $('#sexo').val();
		if(vanio!=""&&vestado!=""&&vsexo!=""){ window.open("./reportes/registros_sexo_rpt.php?anio="+vanio+"&estado="+vestado+"&sexo="+vsexo+"&tr=3", "_self"); } else { alert("\nSELECCIONAR AÑO + ESTADO + SEXO :("); }
	}				
	/* RPTs por PROFESION: */
	document.getElementById("prof_anual").onclick = function (){
		var vanio = $('#anio').val();
		var vprofesion = $('#profesion').val();
		if(vanio!=""&&vprofesion!=""){ window.open("./reportes/registros_profesion_rpt.php?anio="+vanio+"&profesion="+vprofesion+"&tr=1", "_self"); } else { alert("\nSELECCIONAR AÑO + PROFESIÓN :("); }
	}
	document.getElementById("prof_estado").onclick = function (){
		var vanio = $('#anio').val();
		var vestado = $('#estado').val();
		var vprofesion = $('#profesion').val();
		if(vanio!=""&&vestado!=""&&vprofesion!=""){ window.open("./reportes/registros_profesion_rpt.php?anio="+vanio+"&estado="+vestado+"&profesion="+vprofesion+"&tr=3", "_self"); } else { alert("\nSELECCIONAR AÑO + ESTADO + PROFESIÓN :("); }
	}	

	/*Func Ajax manual en ComboBox "año": */
	document.getElementById("anio").onchange = function(){
		var vanioc = $('#anio').val();
		cargarEstados(vanioc);
	}		

}

function cargarEstados(vanioc){
	if (vanioc.length==0) { return; }

	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	} else {
		// IE 5 - 6
		xmlhttp = new ActiveXObject("Microsoft.HMLHTTP");
		alert("Tu navegador no soporta XMLHTTP");
	}
	xmlhttp.onreadystatechange = function(){
		// Capturar estado 4 con 200
		if (xmlhttp.readyState==4) {
			if(xmlhttp.status==200){
				procesaXML(xmlhttp.responseXML);
			} else {
				alert("Error en lectura. Error: "+xmlhttp.status);
			}
		}
	}
	// GET o POST, url, true => Asincrono false => Sincrono
	xmlhttp.open("GET","./js/combos_ajax/xml_estados.php?anio="+vanioc,true);
	// Ejecutar lectura:
	xmlhttp.send();
}
function procesaXML(objetoXML){
	var nodo = objetoXML.documentElement.getElementsByTagName("estado");
	var combo_estado = document.getElementById("estado");
	// Limpiar combo:
	while(combo_estado.length) combo_estado.remove(0);
	//
	var option = document.createElement("option");
	option.innerHTML="-SELECCIONAR-";
	option.setAttribute("value","");
	combo_estado.appendChild(option);

	// Agregar valores del objeto:
	for (var i = 0; i < nodo.length; i++){ 
		id = nodo[i].getElementsByTagName("id_estado");
		idEstado = id[0].firstChild.nodeValue;
		//
		nombre = nodo[i].getElementsByTagName("nombre");
		nombreEstado = nombre[0].firstChild.nodeValue;
		//
		var option = document.createElement("option");
		option.innerHTML = nombreEstado;
		option.setAttribute("value",idEstado);
		combo_estado.appendChild(option);	
	}	
}
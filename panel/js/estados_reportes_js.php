window.onload = function(){
	<?php if ($modo=="S"){ ?>
			document.getElementById("anual").onclick = function (){
				var vanio = <?php print date("Y"); ?>;
				window.open("./reportes/estados_lista_rpt.php?pais&anio="+vanio, "_self");
			}
			document.getElementById("paises").onclick = function (){
				var vaniom = <?php print date("Y"); ?>;
				var vpais = $('#pais').val();
				if(vpais==""){
					alert ("VALOR PAIS REQUERIDO :(");
				}else{
					window.open("./reportes/estados_lista_rpt.php?pais="+vpais+"&anio="+vaniom, "_self");	
				}
			}			
	<?php } ?>			
}
function cambiaPagina(p){
	window.open("estados_reportes.php?p="+p, "_self");
}
window.onload = function(){
	<?php if ($modo=="S"){ ?>
			document.getElementById("lista").onclick = function (){
				window.open("./reportes/usuarios_lista_rpt.php?usuario=todos", "_self");
			}
	<?php } ?>			
}
function cambiaPagina(p){
	window.open("usuarios_reportes.php?p="+p, "_self");
}
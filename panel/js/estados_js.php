window.onload = function(){
	<?php if ($modo=="S"){ ?>
		document.getElementById("agregar").onclick = function (){
			window.open("estados.php?modo=A", "_self");
		}
	<?php } else if($modo=="B"){ ?>
		document.getElementById("si-borrar").onclick = function (){
			var id_estado = <?php print $id_estado; ?>;
			window.open("estados.php?modo=D&id_estado="+id_estado, "_self");
		}
		document.getElementById("no-borrar").onclick = function (){
			window.open("estados.php", "_self");
		}		
	<?php } else { ?>
		document.getElementById("regresar").onclick = function (){
			window.open("estados.php", "_self");
		}
	<?php } ?>		
}
function cambiaPagina(p){
	window.open("estados.php?p="+p, "_self");
}
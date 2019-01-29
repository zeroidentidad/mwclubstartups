window.onload = function(){
	<?php if ($modo=="S"){ ?>
		document.getElementById("agregar").onclick = function (){
			window.open("cat_profesiones.php?modo=A", "_self");
		}
	<?php } else if($modo=="B"){ ?>
		document.getElementById("si-borrar").onclick = function (){
			var id_profesion = <?php print $id_profesion; ?>;
			window.open("cat_profesiones.php?modo=D&id_profesion="+id_profesion, "_self");
		}
		document.getElementById("no-borrar").onclick = function (){
			window.open("cat_profesiones.php", "_self");
		}		
	<?php } else { ?>
		document.getElementById("regresar").onclick = function (){
			window.open("cat_profesiones.php", "_self");
		}
	<?php } ?>			
}
function cambiaPagina(p){
	window.open("cat_profesiones.php?p="+p, "_self");
}
window.onload = function(){
	<?php if ($modo=="S"){ ?>
		document.getElementById("agregar").onclick = function (){
			window.open("usuarios.php?modo=A", "_self");
		}
	<?php } else if($modo=="B"){ ?>
		document.getElementById("si-borrar").onclick = function (){
			var id_usuario = <?php print $id_usuario; ?>;
			window.open("usuarios.php?modo=D&id_usuario="+id_usuario, "_self");
		}
		document.getElementById("no-borrar").onclick = function (){
			window.open("usuarios.php", "_self");
		}		
	<?php } else { ?>
		document.getElementById("regresar").onclick = function (){
			window.open("usuarios.php", "_self");
		}
	<?php } ?>			
}
function cambiaPagina(p){
	window.open("usuarios.php?p="+p, "_self");
}
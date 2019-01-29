window.onload = function(){
	<?php if ($modo=="S"){ ?>
		document.getElementById("agregar").onclick = function (){
			window.open("cat_departamentos.php?modo=A", "_self");
		}
	<?php } else if($modo=="B"){ ?>
		document.getElementById("si-borrar").onclick = function (){
			var id_departamento = <?php print $id_departamento; ?>;
			window.open("cat_departamentos.php?modo=D&id_departamento="+id_departamento, "_self");
		}
		document.getElementById("no-borrar").onclick = function (){
			window.open("cat_departamentos.php", "_self");
		}		
	<?php } else { ?>
		document.getElementById("regresar").onclick = function (){
			window.open("cat_departamentos.php", "_self");
		}
	<?php } ?>			
}
function cambiaPagina(p){
	window.open("cat_departamentos.php?p="+p, "_self");
}
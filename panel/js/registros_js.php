window.onload = function(){
	<?php if ($modo=="S"){ ?>
		document.getElementById("agregar").onclick = function (){
			window.open("registros.php?modo=A", "_self");
		}
	<?php } else if($modo=="B"){ ?>
		document.getElementById("si-borrar").onclick = function (){
			var id_evento = <?php print $id_evento; ?>;
			window.open("registros.php?modo=D&id_evento="+id_evento, "_self");
		}
		document.getElementById("no-borrar").onclick = function (){
			window.open("registros.php", "_self");
		}		
	<?php } else { ?>
		document.getElementById("regresar").onclick = function (){
			window.open("registros.php", "_self");
		}

		document.getElementById("nombre").addEventListener("keypress", forceKeyPressUppercase, false);
		document.getElementById("apellidos").addEventListener("keypress", forceKeyPressUppercase, false);

	<?php } ?>		
}
function cambiaPagina(p){
	window.open("registros.php?p="+p, "_self");
}

function forceKeyPressUppercase(e)
{
	var charInput = e.keyCode;
	    if((charInput >= 97) && (charInput <= 122)) { // lowercase
	      if(!e.ctrlKey && !e.shiftKey && !e.metaKey && !e.altKEY) { // no modifier key
	      	var newChar = charInput - 32;
	      	var start = e.target.selectionStart;
	      	var end = e.target.selectionEnd;
	      	e.target.value = e.target.value.substring(0, start) + String.fromCharCode(newChar) + e.target.value.substring(end);
	      	e.target.setSelectionRange(start+1, start+1);
	      	e.preventDefault();
	      }
	  }
	}
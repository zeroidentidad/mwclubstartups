
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

window.onload=function(){

document.getElementById("nombre").addEventListener("keypress", forceKeyPressUppercase, false);
document.getElementById("apellido").addEventListener("keypress", forceKeyPressUppercase, false);

}
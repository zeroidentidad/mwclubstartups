window.onload = function(){
	<?php if ($modo=="S"){ ?>
			document.getElementById("consulta").onclick = function (){
				var vanio = $('#anio').val();
				var vfolio = $('#id_folio').val();
				var vnombre = $('#nombre').val();
				var vapellidos = $('#apellidos').val();
				var vsexo = $('#sexo').val();
				var vprofesion = $('#profesion').val();
				var vmatricula = $('#matricula').val();
				var vemail = $('#email').val();
				var vcelular = $('#celular').val();
				var vnota = $('#nota').val();

				window.open("./reportes/registros_consultas_rpt.php?anio="+vanio+"&folio="+vfolio+"&nombre="+vnombre+"&apellidos="+vapellidos+"&sexo="+vsexo+"&profesion="+vprofesion+"&matricula="+vmatricula+"&email="+vemail+"&celular="+vcelular+"&nota="+vnota, "_self");	
			}			
	<?php } ?>			

	$(document).ready(function(){
	  $("#fitrotabla").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#mitabla tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	  });
	});

}
function cambiaPagina(p){
	window.open("reportes_consultas.php?p="+p, "_self");
}

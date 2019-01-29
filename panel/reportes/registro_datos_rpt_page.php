<?php
require "../util/conn.php";
require "../clases/ReportesIndividuales.php";

$registro = new ReportesIndividuales();
//
$registro_array = $registro->select_contacto($conn, $id_folio);

// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<style>
	*{margin:0; padding: 0;}
	table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm }
    h1 {color: #000000}
    h2 {color: #000000}
    h3 {color: #000055}
    div.nivel,p{ padding-left: 1mm; padding-right: 1mm; font-size: 18px; text-align: justify; line-height: 15pt; }
    td { padding-left:2px; padding-right:2px; }
    td.td1 { width: 20%; background:#8CCFB7; text-align: left; border: 0.5; }
    td.td2 { width: 80%; text-align: justify; border: 0.5; }        
</style>
		<!-- pageset="old" heredar de la pag anterior conf estilos, diseño-->	
		<page backtop="16mm" backbottom="14mm" backleft="5mm" backright="5mm" style="font-size: 12pt" backimg="">

			<page_header>
				<table class="page_header">
					<tr>
						<td style="width: 100%; text-align: center;">
							<h3><?php print "Registro Fol. ".$registro_array["id_folio"] ?></h3>
						</td>
					</tr>
				</table>
			</page_header>
			<page_footer>
				<table class="page_footer">
					<tr>
						<td style="width: 33%; text-align: left;">
							Fecha: <?php print date("d")." / ".date("m")." / ". date("Y"); ?>
						</td>
						<td style="width: 34%; text-align: center;">
							Página [[page_cu]] de [[page_nb]]
						</td>
						<td style="width: 33%; text-align: right;">
							<a>softcun.co.nf</a>
						</td>												
					</tr>
				</table>				
			</page_footer>
	<?php
			$t = $registro_array["id_folio"];

			print '<bookmark title="'.$registro_array["id_folio"].'" level="0"></bookmark>';
			print '<br>';
			print '<br><h2 style="text-align:center;"><u>Datos de:</u></h2>';
			print '<br><br>';
			print '<bookmark title="'.$t.'" level="1"></bookmark>';

			print "<div with='100%'>";
			print '<h1 style="text-align:center;"><strong>'.$registro_array["nombre"].' '.$registro_array["apellidos"].'</strong></h1>';
			print '<br>';
			print "</div>";
	?>
			<table style="width:100%;" >
			<tr><td class="td1"><b>Año:</b></td><td class="td2"> <?php print $registro_array["anio"] ?></td></tr>
			<tr><td class="td1"><b>Folio:</b></td><td class="td2"> <?php print $registro_array["id_folio"] ?></td></tr>
			<tr><td class="td1"><b>Nombre:</b></td><td class="td2"> <?php print $registro_array["nombre"] ?></td></tr>
			<tr><td class="td1"><b>Apellidos:</b></td><td class="td2"> <?php print $registro_array["apellidos"] ?></td></tr>
			<tr><td class="td1"><b>Sexo:</b></td><td class="td2"> <?php print $registro_array["sexo_descripcion"] ?></td></tr>
			<tr><td class="td1"><b>Profesión:</b></td><td class="td2"> <?php print $registro_array["profesion_descripcion"] ?></td></tr>
			<tr><td class="td1"><b>NDI:</b></td><td class="td2"> <?php print $registro_array["matricula"] ?></td></tr>
			<tr><td class="td1"><b>E-mail:</b></td><td class="td2"> <?php print $registro_array["email"] ?></td></tr>
			<tr><td class="td1"><b>Celular:</b></td><td class="td2"> <?php print $registro_array["celular"] ?></td></tr>
			<tr><td class="td1"><b>Estado:</b></td><td class="td2"> <?php print $registro_array["estado_descripcion"] ?></td></tr>
			<tr><td class="td1"><b>Pais:</b></td><td class="td2"> <?php print $registro_array["pais_estado"] ?></td></tr>
			</table>			
	<?php
			print "<div with='100%'>";
			print '<br>';
			print '<p style="text-align:justify;"><b>Nota:</b></p>';
			print "</div>";
			print "<div class='nivel' style='border-style:solid; border-width:0.5px;' >";
			print html_entity_decode($registro_array["nota"]);
			print "</div>";				

		print '</page>';
	?>
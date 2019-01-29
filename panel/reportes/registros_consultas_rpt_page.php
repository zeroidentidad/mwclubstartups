<?php
require "../util/conn.php";
require "../clases/ReportesConsultas.php";

$consultas = new ReportesConsultas();
//
$registros_array = $consultas->select_contactos($conn, $anio, $folio, $nombre, $apellidos, $sexo, $profesion, $matricula, $email, $celular, $nota);

$total_registros = $consultas->numeroRegistrosReporte($conn, $anio, $folio, $nombre, $apellidos, $sexo, $profesion, $matricula, $email, $celular, $nota);

// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<style>
	*{margin:0; padding: 0;}
	table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
    h1 {color: #000033}
    h2 {color: #000055}
    h3 {color: #000077}
    div.nivel,p{ padding-left: 0mm; font-size: 9pt; text-align: justify; line-height: 15pt; }
    th.th1 { border-collapse:collapse; text-align:center; background:#8CCFB7; }
    td.td2 { border-collapse:collapse; padding-left:3px; padding-right:3px; }
</style>
		<!-- pageset="old" heredar de la pag anterior conf estilos, diseño-->	
		<page backtop="16mm" backbottom="14mm" backleft="0mm" backright="0mm" style="font-size:10pt" backimg="">

			<page_header>
				<table class="page_header">
					<tr>
						<td style="width: 100%; text-align: center;">
							<h1>REGISTROS CONSULTA</h1>
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
			print '<div style="width:100%;">';
			print '<p style="text-align:right;"><b>Total: </b>'.($total_registros).'</p>';
			print "</div>";

			print '<table style="width:100%; border-collapse:collapse;" border="0.75px" bordercolor="black">';
			print '<tr>';
			print '<th class="th1">AÑO</th>';
			print '<th class="th1">ESTADO</th>';
			print '<th class="th1">FOLIO</th>';
			print '<th class="th1">NOMBRE</th>';
			print '<th class="th1">APELLIDOS</th>';
			print '<th class="th1">SEXO</th>';
			print '<th class="th1">PROFESION</th>';
			print '<th class="th1">NDI</th>';
			print '<th class="th1">E-MAIL</th>';
			print '<th class="th1">CELULAR</th>';
			print '<th class="th1">NOTA</th>';
			print '</tr>';
			for ($i=0; $i < count($registros_array); $i++) { 
			print '<tr>';
			print '<td class="td2" style="width:4%;">'.$registros_array[$i]["anio"].'</td>';
			print '<td class="td2" style="width:10%;">'.wordwrap($registros_array[$i]["estado_descripcion"], 8, '<br/>', true).'</td>';
			print '<td class="td2" style="width:5%;">'.wordwrap($registros_array[$i]["id_folio"], 7, '<br/>', true).'</td>';
			print '<td class="td2" style="width:10%;">'.$registros_array[$i]["nombre"].'</td>';
			print '<td class="td2" style="width:10%;">'.$registros_array[$i]["apellidos"].'</td>';
			print '<td class="td2" style="width:9%;">'.$registros_array[$i]["sexo_descripcion"].'</td>';
			print '<td class="td2" style="width:15%;">'.$registros_array[$i]["profesion_descripcion"].'</td>';
			print '<td class="td2" style="width:5%;">'.wordwrap($registros_array[$i]["matricula"], 6, '<br/>', true).'</td>';
			print '<td class="td2" style="width:12%;">'.wordwrap($registros_array[$i]["email"], 15, '<br/>', true).'</td>';
			print '<td class="td2" style="width:8%;">'.$registros_array[$i]["celular"].'</td>';
			print '<td class="td2" style="width:12%;">'.html_entity_decode($registros_array[$i]["nota"]).'</td>';
			print '</tr>';
			}
			print '</table>';

		print '</page>';
	?>
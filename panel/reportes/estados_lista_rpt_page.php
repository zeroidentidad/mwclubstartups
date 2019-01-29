<?php
require "../util/conn.php";
require "../clases/EstadosReportes.php";

$estados = new EstadosReportes();
//
$estados_array = $estados->select_estados($conn, $anio, $pais);

$total_estados = $estados->numeroRegistrosReporte($conn, $anio, $pais);

// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<style>
	*{margin:0; padding: 0;}
	table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm }
    h1 {color: #000033}
    h2 {color: #000055}
    h3 {color: #000077}
    div.nivel,p{ padding-left: 0mm; font-size: 10pt; text-align: justify; line-height: 15pt; }
    th.th1 { border-collapse:collapse; text-align:center; background:#8CCFB7; }
    td.td2 { border-collapse:collapse; padding-left:3px; padding-right:3px; }
</style>
		<!-- pageset="old" heredar de la pag anterior conf estilos, diseño-->	
		<page backtop="16mm" backbottom="14mm" backleft="3mm" backright="3mm" style="font-size: 10pt" backimg="">

			<page_header>
				<table class="page_header">
					<tr>
						<td style="width: 100%; text-align: center;">
							<h1>LISTA DE ESTADOS</h1>
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
			print '<div with="100%">';
			print '<p style="text-align:right;"><b>Total: </b>'.($total_estados).'</p>';
			print "</div>";

			print '<table style="width:100%; border-collapse:collapse;" border="0.75px" bordercolor="black">';
			print '<tr>';
			print '<th class="th1">ESTADO</th>';
			print '<th class="th1">PAIS</th>';
			print '<th class="th1">ESTATUS</th>';
			print '</tr>';
			for ($i=0; $i < count($estados_array); $i++) { 
			print '<tr>';
			print '<td class="td2" style="width:60%;">'.$estados_array[$i]["nombre"].'</td>';
			print '<td class="td2" style="width:27%; text-align:center;">'.$estados_array[$i]["pais"].'</td>';
			print '<td class="td2" style="width:13%; text-align:center;">'.$estados_array[$i]["estatus"].'</td>';
			print '</tr>';
			}
			print '</table>';

		print '</page>';
	?>
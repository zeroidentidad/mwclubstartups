<?php
require "../util/conn.php";
require "../clases/ReportesIndividuales.php";

$registro = new ReportesIndividuales();
//
$registro_array = $registro->select_contacto($conn, $id_folio);

setlocale(LC_TIME,"es_MX.UTF-8");

// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<style>
	/**{margin:0; padding:0;}*/
	table.page_header {width:100%; border:none; background-color:#DDDDFF; border-bottom:solid 1mm #AAAADD; padding:2mm }
    table.page_footer {width:100%; border:none; background-color:#DDDDFF; border-top:solid 1mm #AAAADD; padding:2mm }
    h1 { color:#000000 } h2 { color:#000000 } h3 { color:#000000 /*#000055*/ }
    div.nivel,p{ font-size:20px; text-align: justify; line-height:15pt; }
    td { padding-left:2px; padding-right:2px; }
    td.td1 { width:15%; background:#8CCFB7; }
    td.td2 { width:85%; }
	p.texto_nombre{ padding-left:0mm; font-size:28px; text-align:center; }           
</style>
		<!-- pageset="old" heredar de la pag anterior conf estilos, diseño-->	
		<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size:12pt" backimg="../imgs/fondo_constancia_demo.png">

			<page_header>
				<table style='width:100%;'>
					<tr>
						<td style="width:100%; text-align:right;">
							<?php print "<b>Folio: ".$registro_array["id_folio"]."</b>" ?>
						</td>
					</tr>
				</table>				
			</page_header>
			<page_footer>
			</page_footer>
	<?php 	
			print "<div style='width:100%;'>";
			print '<br>'; print '<br>';
			print '<h1 style="text-align:center;" ><b>WEBAPP CLUB</b></h1>';
			print '<br>'; print '<br>';
			print '<h3 style="text-align:center;" >OTORGA LA PRESENTE:</h3>';
			print '<h2 style="text-align:center;" >CONSTANCIA</h2>';
			print '<br>';
			print '<p class="texto_nombre">A: <b>'.$registro_array["nombre"].' '.$registro_array["apellidos"].'</b></p>';
			print "</div>";
	?>
			<table style='width:100%;' >
				<tr>
					<td style="width:10%;"></td>
					<td style="width:80%; text-align:justify;">
					<?php
					 print '<p>Por ser integrante del <b>CLUB DE STARTUPISMO</b> administrado por <b>FRIC MARTINEZ</b> desde <b>'.$registro_array["pais_estado"]."</b>";
					 print '.</p>';
					?> 
					</td>
					<td style="width:10%;"></td>												
				</tr>
			</table>
	<?php 
			print '<br>'; print '<br>';
	?>
			<table style='width:85%;'>
				<tr>
					<td style="width:100%; text-align:right;">
						<?php print "Desde México; a ".date("d")." de ".strftime("%B")." del ". date("Y");?>
					</td>
				</tr>
			</table>
	<?php 
			print '<br>'; print '<br>'; print '<br>'; print '<br>'; print '<br>'; print '<br>';
	?>			
			<table style='width:100%;'>
				<tr>
					<td style="width:60%; text-align:center;">LIC. JESUS FERRER, PROGRAMADOR</td>
					<td style="width:40%;"></td>
				</tr>
			</table>						
	<?php
		print '</page>';
	?>
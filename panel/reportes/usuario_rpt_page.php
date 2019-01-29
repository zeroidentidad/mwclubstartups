<?php
require "../util/conn.php";
require "../clases/UsuariosReportes.php";

$usuario = new UsuariosReportes();
//
$usuario_array = $usuario->select_usuario($conn, $id_usuario);

// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<style>
	*{margin:0; padding: 0;}
	table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
    h1 {color: #000000}
    h2 {color: #000000}
    h3 {color: #000055}
    div.nivel,p{
		padding-left: 0mm;
		font-size: 18px;
		text-align: justify;
		line-height: 20pt;
    }
</style>
		<!-- pageset="old" heredar de la pag anterior conf estilos, diseño-->	
		<page backtop="16mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt" backimg="">

			<page_header>
				<table class="page_header">
					<tr>
						<td style="width: 100%; text-align: center;">
							<h1><?php print $usuario_array["nombre"]." ".$usuario_array["apellidos"]; ?></h1>
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
			$t = $usuario_array["nombre"]." ".$usuario_array["apellidos"];

			print '<bookmark title="'.$usuario_array["usuario"].'" level="0"></bookmark>';
			print '<br>';
			print '<br><h1 style="text-align:center;"><u>Datos de acceso</u></h1>';
			print '<br><br>';
			print '<bookmark title="'.$t.'" level="1"></bookmark>';

			print "<div style='border-style:solid; border-width:0.5px;'>";
			print '<br>';
			print '<h3>&nbsp;USUARIO:</h3>';
			print '<p style="text-align:center;"><b>'.$usuario_array["usuario"]."</b></p>";
			print '<br>';		
			print '<br>';

			print '<h3>&nbsp;CONTRASEÑA:</h3>';
			print '<p style="text-align:center;"><b>'.$usuario_array["contrasena"]."</b></p>";
			print '<br>';
			print "</div>";

			print "<div class='nivel'>";
			print '<br>';
			print '<p style="text-align:right;"><b>Departamento: </b>'.$usuario_array["id_departamento"]."</p>";
			print '<br>';
			print '<p style="text-align:right;"><b>Rol: </b>'.$usuario_array["id_rol"]."</p>";			
			print "</div>";

		print '</page>';
	?>
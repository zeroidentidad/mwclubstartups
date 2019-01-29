<?php
/*require __DIR__.'/vendor/autoload.php';*/
require '../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
//L = Horizontal apaisado P = Vertical portrait
/* Guia de formatos estaticos : 
github.com/tecnickcom/TCPDF/blob/master/include/tcpdf_static.php*/
/* Guia de diseño de paginas del pdf :
github.com/spipu/html2pdf/blob/master/doc/page.md
*/
if(isset($_GET["anio"])&&isset($_GET["sexo"])&&isset($_GET["tr"])){
	$anio = ""; $estado = "";
	$sexo = ""; $nsexo = ($_GET["sexo"]=='1')?"Mujeres":"Hombres";
	$tr = (isset($_GET["tr"]))?$_GET["tr"]:"";

	if(isset($_GET["tr"])&&$tr=="1"){
		$anio = $_GET["anio"];
		$sexo = $_GET["sexo"];
		$salida = $nsexo."-registros-".$anio.".pdf";
	}
	else if(isset($_GET["tr"])&&$tr=="3"){
		$anio = $_GET["anio"];
		$estado = $_GET["estado"];
		$sexo = $_GET["sexo"];
		$salida = $nsexo."-registros-".$anio."-Edo_".$estado.".pdf";	
	}
	ob_start();
	require_once "registros_sexo_rpt_page.php";
	$html = ob_get_clean();
	$html2pdf = new Html2Pdf('L', 'LETTER', 'es', 'UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output($salida,"D");
}
// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
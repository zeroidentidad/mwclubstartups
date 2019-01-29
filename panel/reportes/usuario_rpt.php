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
if(isset($_GET["id_usuario"])){
	$id_usuario  = $_GET["id_usuario"];
	$usuario = $_GET["usuario"];	
	$salida = $id_usuario."-".$usuario.".pdf";
	ob_start();
	require_once "usuario_rpt_page.php";
	$html = ob_get_clean();
	$html2pdf = new Html2Pdf('P', 'LETTER', 'es', 'UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output($salida,"D");
}
// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
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
if(isset($_GET["anio"])&&isset($_GET["folio"])&&isset($_GET["nombre"])&&isset($_GET["apellidos"])&&isset($_GET["sexo"])&&isset($_GET["profesion"])&&isset($_GET["matricula"])&&isset($_GET["email"])&&isset($_GET["celular"])&&isset($_GET["nota"])){
	$anio = $_GET["anio"];
	$folio = $_GET["folio"];
	$nombre = $_GET["nombre"];
	$apellidos = $_GET["apellidos"];
	$sexo = $_GET["sexo"];
	$profesion = $_GET["profesion"];
	$matricula = $_GET["matricula"];
	$email = $_GET["email"];
	$celular = $_GET["celular"];
	$nota = $_GET["nota"];
	$salida = "consulta.pdf";
	ob_start();
	require_once "registros_consultas_rpt_page.php";
	$html = ob_get_clean();
	$html2pdf = new Html2Pdf('L', 'LETTER', 'es', 'UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output($salida,"D");
}
// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
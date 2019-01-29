<?php
/** Variables paginacion tabla: **/
$TAMANO_PAGINA = 60;
$PAGINAS_MAXIMAS = 10;

if (isset($_GET["p"])) {
	$pagina = $_GET["p"];
}else {
	$pagina = 1;
}
$inicio_p = ($pagina-1)*$TAMANO_PAGINA;
$total_p = ceil($num/$TAMANO_PAGINA);

?>
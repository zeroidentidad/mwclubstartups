<?php
print '<div class="text-left">';
if ($total_p>$PAGINAS_MAXIMAS) {
	if ($pagina==$total_p) {
		$inicio_p = $pagina - $PAGINAS_MAXIMAS;
		$fin = $total_p;
	} else {
		$inicio_p = $pagina;
		$fin = ($inicio_p - 1) + $PAGINAS_MAXIMAS;
		// Ajuste si se sobrepasa el fin a paginar
		if($fin > $total_p){$fin = $total_p;}
	}
	if ($inicio_p!=1) {
		print '<button type="button" onclick="cambiaPagina(1)">Primero</button>';
		print '<button type="button" onclick="cambiaPagina('.($pagina - 1).')">Anterior</button>';
	}

} else {
	$inicio_p = 1;
	$fin = $total_p;
}
for ($i=$inicio_p; $i <= $fin; $i++) { 
	print '<button type="button" ';
	if($i==$pagina) print 'disabled';
	print ' onclick="cambiaPagina('.$i.')">'.$i.'</button>';
}

if ($total_p > $PAGINAS_MAXIMAS && $pagina != $total_p) {
	print '<button type="button" onclick="cambiaPagina('.($pagina + 1).')">Siguiente</button>';
	print '<button type="button" onclick="cambiaPagina('.$total_p.')">Ultimo</button>';
}

print '</div>';
print "<br>";
?>
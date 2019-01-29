<?php
if(isset($msg)){
	for ($i=0; $i < count($msg); $i++) {
		$cadena = substr($msg[$i], 0, 1);
		print "<div style='text-align:center; width:50%; padding:10px; margin:auto; border: 2px solid black; border-radius: 20px; ";
		if ($cadena=="0") print "background-color:#66ff66;' ";
		if ($cadena=="1") print "background-color:#ff6666;' ";
		if ($cadena=="2") print "background-color:#ffdb4d;' ";
		print "><b>";
		print substr($msg[$i], 1);
		print "</b></div>";										
	}
}
?>
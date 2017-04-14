297582
<?php 
$arquivo = "contador-visitas.txt"; 
$contador = 0; 
$fp = fopen($arquivo,"r"); 
$contador = fgets($fp, 26); 
fclose($fp); 
++$contador; 
$fp = fopen($arquivo,"w+"); 
fwrite($fp, $contador, 26); 
fclose($fp); 
"Esta página foi visitada $contador vezes"; 
?>	

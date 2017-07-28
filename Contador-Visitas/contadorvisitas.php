
<? php 
$arquivo = "contadorvisitas.txt"; 
$contador = (integer)0; 
$fp = fopen($arquivo,"r"); 
$contador = fgets($fp, 26); 
fclose($fp); 
++$contador; 
$fp = fopen($arquivo,"w+"); 
fwrite($fp, $contador, 26); 
fclose($fp); 
echo "Esta página foi visitada $contador vezes"; 
?>	

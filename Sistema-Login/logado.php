<?php 
	  include('classes/DB.class.php');
	  include('classes/Login.class.php');
	  
	  $objLogin = new Login;
	  
	  if(!$objLogin->logado()){
		  include('login.php');
		  exit();
	  }
	  
	  if(true==$_GET['sair']){
	  	$objLogin->sair();
		header('Location ./');		
	  }
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0" />
<title>Teste.com - Index</title>
</head>
<body>        

Logado: <a href="?sair=true">sair</a>

</body>
</html>
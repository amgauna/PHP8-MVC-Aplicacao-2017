<?php
session_start();
 
require 'init.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
 
        <title>Sistema de Login</title>
    </head>
 
    <body>
         
        <h1>Sistema de Login</h1>
 
        <?php if (isLoggedIn()): ?>
            <p>Olá, <?php echo $_SESSION['user_name']; ?>. <a href="panel.php">Painel</a> | <a href="logout.php">Sair</a></p>
        <?php else: ?>
            <p>Olá, faça o <a href="form-login.php">Login</a></p>
        <?php endif; ?>
 
    </body>
</html>
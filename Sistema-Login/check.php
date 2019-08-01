<?php
// verifica se o usuario está logado
 
require_once 'init.php';
 
if (!isLoggedIn())
{
    header('Location: form-login.php');
}
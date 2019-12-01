<?php
 
require_once ('init.php');
 
if (!isLoggedIn())
{
    header('Location: ', require_once('form-login.php') );
}

?>

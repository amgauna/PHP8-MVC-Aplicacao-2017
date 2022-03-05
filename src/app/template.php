<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
 
        <title>Sistema de Cadastro em MVC</title>
    </head>
 
    <body>
         
        <?php if (isset($viewName)) { $path = viewsPath() . $viewName . '.php'; if (file_exists($path)) { require_once $path; } } ?>
 
    </body>
</html>

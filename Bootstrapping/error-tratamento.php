<?php 

/* Erro intencional de arquivo */

$my_file = @file ('arquivo_nao_existente') or die("Falha abrindo arquivo: '$php_errormsg'");
 
// Isto funciona para qualquer expressão, não apenas para funções:

$valor = @$carrinho[$produto];

// você não receberá nenhum aviso se a chave $produto não existir.

?>


<?php 

// Exemplo 2.2.2 Ocultar erro em conexões com banco de dados
// Usando o @ você pode ocultar erros de conexões com o banco de dados:

@mysql_connect("localhost", "root") or die("Mensagem de erro");

// Usando o @ podemos ocultar a mensagem de erro do PHP, mas devemos, ainda, informar 
// o usuário e exibir uma mensagem de erro personalizado, podendo usar CSS, imagens etc. 
// O mesmo vale para erros na abertura de arquivos ou envio de e-mails.

// Erro de indice não encontrado

$val = $_POST[val]; // erro não delimitou uma string com aspas ou apóstrofos

?>



<?php 

//  Exemplos error_reporting()

// Desativa o relatório de todos os erros
error_reporting(0);
// Reporta erros simples
error_reporting(E_ERROR | E_WARNING | E_PARSE);
 
// Reportar E_NOTICE pode ser bom também (para reportar variáveis não iniciadas
// ou erros de digitação em nomes de variáveis ...)
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
// Reportar todos os erros exceto E_NOTICE
// Este é o valor padrão no php.ini
error_reporting(E_ALL ^ E_NOTICE);
 
// Reporta todos os erros (bitwise 63 deve ser usado no PHP 3)
error_reporting(E_ALL);
// O mesmo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
?>


<?php 

// Como debugar um script
// Para testar um script e ver se ele está funcionando corretamente, há várias maneiras. 
// A primeira delas é testar num servidor local. Para desenvolver, sempre deixe essas 
// opções configuradas no php.ini:

// display_errors = On
// display_startup_errors = On
// error_reporting = E_ALL
// log_errors = On
// track_errors = On
// register_globals = Off

// Via script você pode fazer assim:

@ini_set("display_errors", 1);
@ini_set("log_errors", 1);
@ini_set("error_reporting", E_ALL);

// Em versões do PHP igual ou anterior à 4.2.3 era possível setar a diretiva register_globals
// via script, mas agora só via PHP.INI ou .htaccess. Via .htaccess é assim:

php_flag register_globals off

// Validações para evitar erros

// Um bom tratamento de erros precisa prever vários tipos de erros e, pra isso, 
// existem funções específicas, como por exemplo:

// file_exists – serve para verificar se um arquivo existe
// defined – serve para verificar se uma constante foi definida.
// isset – verifica se uma variável existe.
// is_array – verifica se a variável é um array
// is_resource – verifica se a variável é um resource
// is_numeric – verifica se a variável é um número ou uma string numérica.
// is_uploaded_file – verifica se o arquivo foi uploaded via HTTP POST.
// is_writable – verifica se pode escrever para o arquivo (writable).
// version_compare – Compara a versão do php.
// extension_loaded – verifica se a extensão foi habilitada.

// Com essas funções você pode testar, por exemplo, se um arquivo existe, antes de incluí-lo. 
// Caso não exista, você pára o script e dá um aviso para o usuário. 
// Outro exemplo: antes de gravar um arquivo texto, você verifica se ele pode ser escrito, 
// ou antes de usar uma variável teste, se ela existe com isset()
// Outra validação muito importante é validar se o formulário foi enviado, assim evitando erro, por exemplo:

// Exemplo Verificando se um formulário foi enviado

if (getenv("REQUEST_METHOD") == "POST") {
    //...faça tal coisa
}

// Se for get só mudar para GET, assim você testa se o formulário foi enviado.
// Outra dica importante é testar se a variável existe caso venha de algum formulário:

Exemplo Verificando se uma variável foi inicializada

$campo = isset($_POST["campo"]) ? $_POST["campo"] : "";
?>


<?php 

// Exemplo Incluindo um arquivo sem verificação de tratamento de erros:

 require "arquivo.php";

// Mas e se o arquivo nao existir? Iria dar erro, então o mais correto é:
// Exemplo Incluindo um arquivo com verificação

if (file_exists("arquivo.php")) {
 require "arquivo.php";
}
?>

<?php

// Exemplo Desabilitando magic_quotes
// Programar dependente de magic_quotes não é recomendando, visto que o site ou sistema 
// poderá não funcionar corretamente caso seja hospedado em um servidor com configuração
// divergente da que foi adotada para os testes locais. Os erros mais comuns são na inserção 
// de valores em um banco de dados. Além disso, a partir do PHP 6, a diretiva magic_quotes_gpc
// não existirá mais e, por isso, é recomendado programar desabilitando este recurso. 
// Esta diretiva não pode ser alterada através da função ini_set, devendo ser configurada 
// diretamente no PHP.INI ou, se também possível, através do .htaccess, da seguinte forma:

php_flag magic_quotes_gpc Off

// Como alternativa, você pode utilizar a função abaixo:

function remove_magic_quotes() {
 if (get_magic_quotes_gpc()) {
  $_GET = array_map("remove_mq", $_GET);
  $_POST = array_map("remove_mq", $_POST);
  $_REQUEST = array_map("remove_mq", $_REQUEST);
  $_COOKIE = array_map("remove_mq", $_COOKIE);
 }
}
 
function remove_magic_quotes(&amp;$var) {
 return is_array($var) ? array_map("remove_magic_quotes", $var) : stripslashes($var);
}

// Basicamente, a função verifica se a diretiva magic_quotes está habilitada e, então, 
// varre pelos dados dos arrays globais inicializados (enviados por um formulário, por 
// exemplo), eliminando os escapes dos caracteres. Preferencialmente, esta função deve
// ser chamada num arquivo de inicialização do sistema ou site.

// Tratando erros com Exceções

// A partir da versão 5 do PHP, pode-se tratar erros usando Exceções. Com o uso desse recurso, 
// podemos manipular os erros com mais precisão, facilitando, por exemplo, a criação de um log 
// de erros contendo o nome do arquivo e a linha em que o erro ocorreu.
// A classe Exception pode ser extendida a uma outra, viabilizando a personalização de mensagens 
// de erro e a criação de uma classe para cada tipo de exceção. 
// Por exemplo: é possível termos uma classe para manipular erros relacionados a banco de dados, 
// outra para o manuseio de arquivos, de imagens, etc.
// Uma exceção deve ser disparada (thrown) dentro de um bloco try{}. Em seguida, deve ser pega
// (catched) usando o bloco catch{}.

// Exemplo Usando exceções para capturar um possível erro na conexão com um banco de dados MySQL

try {
   //usamos o arroba para ocultar o possível erro retornado pelo PHP
   @$MySQLi = new MySQLi("localhost", "user", "pass", "db_name");
 
   if (!$MySQLi) { //se conexão falhar
      throw new Exception("Erro ao realizar a conexão com o banco de dados");
   }
}
catch (Exception $e) {
 echo $e->getMessage();
 exit;
}

// Se a conexão falhar, será disparada uma exceção, que será, posteriormente, pega no seu bloco catch 
// correspondente. Nesse bloco, devemos colocar o nome da classe de exceção utilizada e criar uma variável,
// a qual será uma instância da exceção.

// Para obter mais informações sobre exceções, veja o link abaixo:
// http://www.php.net/manual/pt_BR/language.exceptions.php
// http://rberaldo.com.br/tratamento-erros-php/


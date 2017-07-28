<?php 
 
/* =============================
   Configurações do PHP
   =========================== */
 
// define valores padrão para diretivas do php.ini
ini_set( 'error_reporting', -1 );
ini_set( 'display_errors', 0 ); // deve ser definida para zero (0) em ambiente de produção
 
// timezone
date_default_timezone_set( 'America/Sao_Paulo' );
 
 
// tempo máximo de execução de um script
set_time_limit( 60 );
  
 
/* ======================================
   Cria constantes usadas na aplicação
   =================================== */
 
// conexão com base de dados
define( 'BD_SERVIDOR', 'localhost' );
define( 'BD_USUARIO', 'usuario' );
define( 'BD_SENHA', 'senha' );
define( 'BD_NOME', 'nome_banco' );
 
// conexão SMTP
define( 'SMTP_SERVIDOR', 'mail.servidor.com.br' );
define( 'SMTP_USUARIO', 'usuario' );
define( 'SMTP_SENHA', 'senha' );

?>
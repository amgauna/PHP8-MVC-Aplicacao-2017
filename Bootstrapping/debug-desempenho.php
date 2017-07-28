<?php
require_once 'php-config.php';
 
// limpa o cache inicialmente, apenas para nosso teste de desempenho
apc_clear_cache();
 
function getConfig( $configName )
{
    // chave utilizada no APC para identificar o array $config no cache
    $apcConfigKey = 'app_config';
 
    // horário inicial, para nosso teste de desempenho
    $start = microtime( true );
 
    if ( ! apc_exists( $apcConfigKey ) )
    {
        echo "Buscando no arquivo...";
 
        $configFile = '../config.ini';
 
        $config = parse_ini_file( $configFile, true );
 
        // armazena em cache por 15 minutos (900 segundos)
        apc_store( $apcConfigKey, $config, 900 ); 
    }
    else
    {
        echo "Buscando no cache...";
 
        $config = apc_fetch( $apcConfigKey );
    }
 
    list( $section, $param ) = explode( '.', $configName );
 
    if ( array_key_exists( $section, $config ) )
    {
        if ( array_key_exists( $param, $config[ $section ] ) )
        {
            // tempo de execução total
            $time = microtime( true ) - $start;
            echo "Tempo total: " . number_format( $time, 20 );
 
            return $config[ $section ][ $param ];
        }
    }
 
    return null;
}
 
// Buscando dois dados, para comparar o tempo de acesso ao disco e ao cache
var_dump( getConfig( 'db.host' ) );
var_dump( getConfig( 'db.user' ) );

?>

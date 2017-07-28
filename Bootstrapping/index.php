<?php
require_once 'php-config.php';
 
function getConfig( $configName )
{
    $apcConfigKey = 'app_config';
 
    if ( ! apc_exists( $apcConfigKey ) )
    {
        $configFile = '../config.ini';
 
        $config = parse_ini_file( $configFile, true );
 
        // armazena em cache por 15 minutos (900 segundos)
        apc_store( $apcConfigKey, $config, 900 ); 
    }
    else
    {
        $config = apc_fetch( $apcConfigKey );
    }
 
 
    list( $section, $param ) = explode( '.', $configName );
 
    if ( array_key_exists( $section, $config ) )
    {
        if ( array_key_exists( $param, $config[ $section ] ) )
        {
            return $config[ $section ][ $param ];
        }
    }
 
    return null;
}

?>
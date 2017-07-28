<?php
 
require_once 'php-config.php';
 
 
function getConfig( $configName )
{
    $configFile = '../config.ini';
 
    $config = parse_ini_file( $configFile, true );
 
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

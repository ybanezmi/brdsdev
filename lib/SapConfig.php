<?php

namespace app\lib;

class SapConfig
{
    public static $getTable = "dev";
    public static $funcNumber = "110";

    public static function msqlconn() {
        $serverName = "DEV";
        $connectionInfo = array("Database" => "DEV", "UID"=>"Manten", "PWD"=>"@kaitou2");
        return $conn = sqlsrv_connect( $serverName, $connectionInfo); 
    }

}
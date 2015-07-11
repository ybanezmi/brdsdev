<?php

namespace app\lib;

class SapConfig
{
    public static $getTable = "qas";
    public static $funcNumber = "400";

    public static function msqlconn() {
        $serverName = "QASV";
        $connectionInfo = array("Database" => "QAS", "UID"=>"Manten", "PWD"=>"@kaitou2");
        return $conn = sqlsrv_connect( $serverName, $connectionInfo); 
    }

}
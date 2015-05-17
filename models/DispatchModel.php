<?php
namespace app\models;
use Yii;




class DispatchModel extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dispatch_table';
    }

    public function getDispatchList($dr)
    {
        //MSSQL Credentials
        $serverName = "QASV";
        $connectionInfo = array( "Database"=>"QAS", "UID"=>"Manten", "PWD"=>"@kaitou2");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn ) {
            $stmt = "SELECT qas.LIKP.VBELN, qas.LIKP.KUNNR,  qas.LIKP.KUNAG, qas.LIKP.BLDAT, qas.LIKP.XABLN  
                     FROM qas.LIKP  WHERE qas.LIKP.VBELN ='".$dr."' AND qas.LIKP.MANDT = '400'";
            if(($result = sqlsrv_query($conn,$stmt)) !== false){
                $return_value = array();
                while( $obj = sqlsrv_fetch_object( $result )) {
                      array_push( $return_value, $obj);
                }
                return $return_value;
            }
        } else{
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function getDispatchItems($dr)
    {
        //MSSQL Credentials
        $serverName = "QASV";
        $connectionInfo = array( "Database"=>"QAS", "UID"=>"Manten", "PWD"=>"@kaitou2");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn ) {
            $stmt = "SELECT qas.LIPS.MATNR, qas.LIPS.ARKTX, qas.LIPS.CHARG, qas.LIPS.UMVKZ, qas.LIPS.VRKME, qas.LIPS.LFIMG, qas.LIPS.VFDAT, qas.LIPS.MEINS, qas.LIPS.VOLUM FROM qas.LIPS WHERE qas.LIPS.VBELN ='".$dr."' AND qas.LIPS.MANDT = '400'";
            if(($result = sqlsrv_query($conn,$stmt)) !== false){
                $return_value = array();
                while( $obj = sqlsrv_fetch_object( $result )) {
                      array_push( $return_value, $obj);
                }
                return $return_value;
            }
        } else{
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public static function getKUNNR($filter) {
        $serverName = "QASV"; //serverName\instanceName
        $connectionInfo = array( "Database"=>"QAS", "UID"=>"Manten", "PWD"=>"@kaitou2");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn ) {

            $stmt = "SELECT qas.KNA1.NAME1 FROM qas.KNA1 WHERE qas.KNA1.KUNNR ='".$filter."'";

            if(($result = sqlsrv_query($conn,$stmt)) !== false){
                 $return_value = array();
                while( $obj = sqlsrv_fetch_object( $result )) {
                      array_push( $return_value, $obj);
                }

                return $return_value;
            }
        } else{
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    }

     public function getCustomerData($filter) {
        $serverName = "QASV"; //serverName\instanceName
        $connectionInfo = array( "Database"=>"QAS", "UID"=>"Manten", "PWD"=>"@kaitou2");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn ) {

            $stmt = "SELECT qas.KNA1.NAME1, qas.KNA1.STRAS, qas.KNA1.ORT01, qas.KNA1.LAND1, qas.KNA1.PSTLZ, qas.KNA1.TELF1 
                    FROM qas.KNA1 WHERE qas.KNA1.KUNNR ='".$filter."'";

            if(($result = sqlsrv_query($conn,$stmt)) !== false){
                 $return_value = array();
                while( $obj = sqlsrv_fetch_object( $result )) {
                      array_push( $return_value, $obj);
                }

                return $return_value;
            }
        } else{
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    }

     public function getSO($filter) {
        $serverName = "QASV"; //serverName\instanceName
        $connectionInfo = array( "Database"=>"QAS", "UID"=>"Manten", "PWD"=>"@kaitou2");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn ) {

            $stmt = "SELECT qas.VBFA.VBELV, qas.VBFA.ERDAT FROM qas.VBFA WHERE qas.VBFA.VBELN ='".$filter."'";

            if(($result = sqlsrv_query($conn,$stmt)) !== false){
                 $return_value = array();
                while( $obj = sqlsrv_fetch_object( $result )) {
                      array_push( $return_value, $obj);
                }

                return $return_value;
            }
        } else{
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    }

     public function getPO($filter) {
        $serverName = "QASV"; //serverName\instanceName
        $connectionInfo = array( "Database"=>"QAS", "UID"=>"Manten", "PWD"=>"@kaitou2");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn ) {

            $stmt = "SELECT qas.VBAK.BSTNK, qas.VBAK.BSTDK
                    FROM qas.VBAK WHERE qas.VBAK.VBELN ='".$filter."' AND qas.LIKP.MANDT = '400'";

            if(($result = sqlsrv_query($conn,$stmt)) !== false){
                 $return_value = array();
                while( $obj = sqlsrv_fetch_object( $result )) {
                      array_push( $return_value, $obj);
                }

                return $return_value;
            }
        } else{
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    }

}

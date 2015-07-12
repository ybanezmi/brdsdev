<?php
namespace app\models;
use app\lib\SapConfig;
use Yii;

class DispatchModel extends \yii\db\ActiveRecord
{

    public function getDispatchList($dr)
    {
        $conn = SapConfig::msqlconn();
        $tn = SapConfig::$getTable;
        $fnumb = SapConfig::$funcNumber;

        if( $conn ) {
            $stmt = "SELECT $tn.LIKP.VBELN, $tn.LIKP.KUNNR,  $tn.LIKP.KUNAG, $tn.LIKP.BLDAT, $tn.LIKP.XABLN  
                     FROM $tn.LIKP  WHERE $tn.LIKP.VBELN ='".$dr."' AND $tn.LIKP.MANDT = $fnumb";

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
        $conn = SapConfig::msqlconn();
        $tn = SapConfig::$getTable;
        $fnumb = SapConfig::$funcNumber;

        if( $conn ) {
            $stmt = "SELECT $tn.LIPS.MATNR, $tn.LIPS.ARKTX, $tn.LIPS.CHARG, $tn.LIPS.UMVKZ, $tn.LIPS.GEWEI, $tn.LIPS.VRKME, $tn.LIPS.LFIMG, $tn.LIPS.VFDAT, $tn.LIPS.MEINS, $tn.LIPS.VOLUM FROM $tn.LIPS WHERE $tn.LIPS.VBELN ='".$dr."' AND $tn.LIPS.MANDT = $fnumb";
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
        $conn = SapConfig::msqlconn();
        $tn = SapConfig::$getTable;
        $fnumb = SapConfig::$funcNumber;

        if( $conn ) {
            $stmt = "SELECT $tn.KNA1.NAME1 FROM $tn.KNA1 WHERE $tn.KNA1.KUNNR ='".$filter."'";
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
        $conn = SapConfig::msqlconn();
        $tn = SapConfig::$getTable;
        $fnumb = SapConfig::$funcNumber;

        if( $conn ) {
            $stmt = "SELECT $tn.KNA1.NAME1, $tn.KNA1.STRAS, $tn.KNA1.ORT01, $tn.KNA1.LAND1, $tn.KNA1.PSTLZ, $tn.KNA1.TELF1 
                    FROM $tn.KNA1 WHERE $tn.KNA1.KUNNR ='".$filter."'";
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
        $conn = SapConfig::msqlconn();
        $tn = SapConfig::$getTable;
        $fnumb = SapConfig::$funcNumber;

        if( $conn ) {
            $stmt = "SELECT $tn.VBFA.VBELN, $tn.VBFA.ERDAT FROM $tn.VBFA WHERE $tn.VBFA.VBELV ='".$filter."' AND $tn.VBFA.VBTYP_N = 'Q'";
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
        $conn = SapConfig::msqlconn();
        $tn = SapConfig::$getTable;
        $fnumb = SapConfig::$funcNumber;

        if( $conn ) {
            $stmt = "SELECT $tn.VBAK.BSTNK, $tn.VBAK.BSTDK FROM $tn.VBAK WHERE $tn.VBAK.VBELN ='".$filter."' AND $tn.VBAK.MANDT = $fnumb";
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

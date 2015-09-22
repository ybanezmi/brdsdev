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
            $stmt = "SELECT $tn.LIKP.VBELN, $tn.LIKP.KUNNR,  $tn.LIKP.KUNAG, $tn.LIKP.BLDAT, $tn.LIKP.XABLN, $tn.LIKP.ERNAM  
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
            $stmt = "SELECT $tn.LIPS.MATNR, $tn.LIPS.ARKTX, $tn.LIPS.CHARG, $tn.LIPS.UMVKZ, $tn.LIPS.BRGEW, $tn.LIPS.VRKME, $tn.LIPS.LFIMG, $tn.LIPS.VFDAT, $tn.LIPS.MEINS, $tn.LIPS.VOLUM, $tn.LIPS.UMVKZ, $tn.LIPS.UMVKN FROM $tn.LIPS WHERE $tn.LIPS.VBELN ='".$dr."' AND $tn.LIPS.MANDT = $fnumb";
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

    public function getPickedBy($dr)
    {
        $conn = SapConfig::msqlconn();
        $tn = SapConfig::$getTable;
        $fnumb = SapConfig::$funcNumber;

        if( $conn ) {
            $stmt = "SELECT $tn.LTAP.QNAME FROM $tn.LTAP WHERE $tn.LTAP.VBELN ='".$dr."' AND $tn.LTAP.PQUIT = 'X'";
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

     public function getConfirmDispatchItems($dr)
    {
        $conn = SapConfig::msqlconn();
        $tn = SapConfig::$getTable;
        $fnumb = SapConfig::$funcNumber;

        if( $conn ) {
            $stmt = "SELECT $tn.LTAP.MATNR, $tn.LTAP.MAKTX, $tn.LTAP.CHARG, $tn.LTAP.VFDAT,  $tn.LTAP.VISTM, $tn.LTAP.ALTME, $tn.LTAP.UMREZ, $tn.LTAP.UMREN, $tn.LTAP.VOLUM, $tn.LTAP.QNAME FROM $tn.LTAP WHERE $tn.LTAP.VBELN ='".$dr."' AND $tn.LTAP.PQUIT = 'X'";
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

    private function ms_escape_string($data) {
       
        if ( !isset($data) or empty($data) ) return '';
        if ( is_numeric($data) ) return $data;

        $non_displayables = array(
            '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
            '/%1[0-9a-f]/',             // url encoded 16-31
            '/[\x00-\x08]/',            // 00-08
            '/\x0b/',                   // 11
            '/\x0c/',                   // 12
            '/[\x0e-\x1f]/'             // 14-31
        );

        foreach ( $non_displayables as $regex )
            $data = preg_replace( $regex, '', $data );
        $data = str_replace("'", "''", $data );

        return $data;
     }


     public function getCustomerData($filter) {
        $conn = SapConfig::msqlconn();
        $tn = SapConfig::$getTable;
        $fnumb = SapConfig::$funcNumber;
          
          $filter_escape = $this->ms_escape_string($filter);

        if( $conn ) {
            $stmt = "SELECT $tn.KNA1.NAME1, $tn.KNA1.STRAS, $tn.KNA1.ORT01, $tn.KNA1.LAND1, $tn.KNA1.PSTLZ, $tn.KNA1.TELF1 
                    FROM $tn.KNA1 WHERE $tn.KNA1.KUNNR ='".$filter_escape."'";
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
            $stmt = "SELECT $tn.VBFA.VBELV, $tn.VBFA.ERDAT FROM $tn.VBFA WHERE $tn.VBFA.VBELN ='".$filter."'";
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

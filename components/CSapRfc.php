<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\constants\SapConst;

class CSapRfc extends Component
{

    public static function config() {
        return [
            'ASHOST'    =>    '192.168.1.13',
            'SYSNR'     =>    '00',
            'CLIENT'    =>    '110',
            'USER'      =>    'dtcustodian',
            'PASSWD'    =>    'bigblue',
            'LANG'      =>    'EN'
        ];
    }

    public function open() {
        $rfc = saprfc_open($sap_config);

        if (! $rfc) {
            echo 'An error occured: <pre>';
            print_r(saprfc_error());
            exit;
        }

        return $rfc;
    }

    public function close($fce, $rfc) {
        saprfc_function_free($fce);
        saprfc_close($rfc);
    }

    public function callFunction($fxnName, $rsInputParams) {
        $rfc = $this->open();
        $fce = saprfc_function_discover($rfc, $fxnName);
        if(! $fce) {
            echo 'Discovering interface of function module ZBAPI_RECEIVING failed';
            exit;
        }

        saprfc_import($fce, SapConst::RS_INPUT, $rsInputParams);

        saprfc_import($fce, SapConst::PRINTER, SapConst::ZWI6);

        saprfc_table_init($fce, SapConst::ET_PALLETS);
        saprfc_table_init($fce, SapConst::ET_PALLETS_W_TO);

        $sn = saprfc_export($fce, SapConst::VBELN);
        $ol = saprfc_export($fce, SapConst::OBJECT_LOCKED);
        $nc = saprfc_export($fce, SapConst::NOT_COMPATIBLE);
        $vc = saprfc_export($fce, SapConst::VOLUME_CAP_ERROR);
        $oe = saprfc_export($fce, SapConst::OTHER_ERROR);

        if(saprfc_call_and_receive($fce) == SAPRFC_OK){
            echo '<h2>Pulled Data</h2>';
            echo 'SAP #:'. $sn .'<br />';
            echo 'Object Locked:'. $ol .'<br />';
            echo 'Not Compatible:'. $nc .'<br />';
            echo 'Volume Cap Error:'. $vc .'<br />';
            echo 'Other Error:'. $oe .'<br />';
        }

        $data_et_pallets = saprfc_table_rows ($fce, SapConst::ET_PALLETS);
        $data_et_pallets_w_to = saprfc_table_rows ($fce, SapConst::ET_PALLETS_W_TO);
    }

    public function callFunctionTest() {
        $rfc = $this->open();
        $fce = saprfc_function_discover($rfc, 'ZBAPI_RECEIVING');
        if(! $fce) {
            echo 'Discovering interface of function module ZBAPI_RECEIVING failed';
            exit;
        }
        saprfc_import($fce, RSINPUT,array(
                'ZEX_VBELN'    =>    '1500000000',//always null in first submit (transaction number)
                'KUNNR' => 'ANGELITO', //ship to party
                'MATNR' => 'ANGELITO0002', // Material
                'LFIMG' => '5.000', // Deliv Qty
                'CHARG' => '1427279260', // batch #
                'WERKS' => 'BBL2', //location
                'LFART' => 'ZEL', //fixed value
                'LGORT' => 'B201', // storage
                'XABLN' => 'ZXY12345',
                'WADAT' => '04/25/2015', //current date
                'WDATU' => '04/25/2015', // submitted date
                'HSDAT' => '04/03/2014', // manuf. date
                'VFDAT' => '04/05/2015', // expiry date
                'CRATES_IND' => '', // null (already exist in BAPI)
                'EXIDV' => '', //handling unit (range)
                'VHILM' => '36', //Packaging material (pack icon) select allowed material >> (hu) empty or same as vhilm2.
                'VHILM2' => '36', // packing Materials (always has an entry)
                'REMARKS' => 'TEST', // Extras > headers > text
                'LAST_ITEM_IND' => ' ',
        ));

        saprfc_import($fce,'PRINTER','ZWI6');
        saprfc_table_init($fce,'ET_PALLETS');
        saprfc_table_init($fce,'ET_PALLETS_W_TO');

        $sn = saprfc_export($fce, 'VBELN');
        $ol = saprfc_export($fce, 'OBJECT_LOCKED');
        $nc = saprfc_export($fce, 'NOT_COMPATIBLE');
        $vc = saprfc_export($fce, 'VOLUME_CAP_ERROR');
        $oe = saprfc_export($fce, 'OTHER_ERROR');

        if(saprfc_call_and_receive($fce) == SAPRFC_OK){
            echo '<h2>Pulled Data</h2>';
            echo 'SAP #:'. $sn .'<br />';
            echo 'Object Locked:'. $ol .'<br />';
            echo 'Not Compatible:'. $nc .'<br />';
            echo 'Volume Cap Error:'. $vc .'<br />';
            echo 'Other Error:'. $oe .'<br />';
        }

        $data_et_pallets = saprfc_table_rows ($fce,'ET_PALLETS');
        $data_et_pallets_w_to = saprfc_table_rows ($fce,'ET_PALLETS_W_TO');

        $this->close($fce, $rfc);
    }
}

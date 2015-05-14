<?php

namespace app\constants;

class SapConst
{
    // common
    const EMPTY_STRING = '';
    const HALF_WIDTH_SPACE = ' ';
    const PARAMS = 'PARAMS';
    const X = 'X';

    // config
    const ASHOST = 'ASHOST';
    const SYSNR = 'SYSNR';
    const CLIENT = 'CLIENT';
    const USER = 'USER';
    const PASSWD = 'PASSWD';
    const LANG = 'LANG';

    // functions
    const RFC_FUNCTION = 'RFC_FUNCTION';
    const ZBAPI_RECEIVING = 'ZBAPI_RECEIVING';

    // RS_INPUT
    const RS_INPUT = 'RS_INPUT';
    // transaction number
    const ZEX_VBELN = 'ZEX_VBELN';
    // ship to party
    const KUNNR = 'KUNNR';
    // material
    const MATNR = 'MATNR';
    // delivery quantity
    const LFIMG = 'LFIMG';
    // batch no.
    const CHARG = 'CHARG';
    // location
    const WERKS = 'WERKS';
    // fixed value
    const LFART = 'LFART';
    const ZEL = 'ZEL';
    // stoarage
    const LGORT = 'LGORT';
    // static value
    const XABLN = 'XABLN';
    // current date
    const WADAT = 'WADAT';
    // submitted date
    const WDATU = 'WDATU';
    // manufacturing date
    const HSDAT = 'HSDAT';
    // expiry date
    const VFDAT = 'VFDAT';
    // null (already exists in BAPI)
    const CRATES_IND = 'CRATES_IND';
    // handling unit (range)
    const EXIDV = 'EXIDV';
    // pallet number
    const EXIDV_PAL = 'EXIDV_PAL';
    // packaging material (pack icon) select allowed material >> (hu) empty or same as vhilm2.
    const VHILM = 'VHILM';
    // packing material (always has an entry)
    const VHILM2 = 'VHILM2';
    // extras > headers > text
    const REMARKS = 'REMARKS';
    const LAST_ITEM_IND = 'LAST_ITEM_IND';

    // PRINTER
    const PRINTER = 'PRINTER';
    const ZWI6 = 'ZWI6';

    // ET_PALLETS
    const ET_PALLETS = 'ET_PALLETS';
    const ET_PALLETS_W_TO = 'ET_PALLETS_W_TO';

    // export
    const VBELN = 'VBELN';
    const OBJECT_LOCKED = 'OBJECT_LOCKED';
    const NOT_COMPATIBLE = 'NOT_COMPATIBLE';
    const VOLUME_CAP_ERROR = 'VOLUME_CAP_ERROR';
    const OTHER_ERROR = 'OTHER_ERROR';

}
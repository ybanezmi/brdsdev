<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_compatibility".
 *
 * @property string $id
 * @property string $matnr
 * @property string $mbrsh
 * @property string $mtart
 * @property string $werks
 * @property string $maktx
 * @property string $meins
 * @property string $matkl
 * @property string $extwg
 * @property string $mtpos_mara
 * @property string $gewei
 * @property string $magrv
 * @property string $mtvfp
 * @property string $tragr
 * @property string $ladgr
 * @property string $vhart
 * @property string $ergew
 * @property string $ergei
 * @property string $gewto
 * @property string $ervol
 * @property string $ervoe
 * @property string $volto
 * @property string $dismm
 * @property string $beskz
 * @property string $perkz
 * @property string $prmod
 * @property string $peran
 * @property string $anzpr
 * @property string $kzini
 * @property string $siggr
 * @property string $autru
 * @property string $modav
 * @property string $iprkz
 * @property string $status
 * @property string $creator_id
 * @property string $created_date
 * @property string $updater_id
 * @property string $updated_date
 */
class MstCompatibility extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mst_compatibility';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['matnr', 'mbrsh', 'mtart', 'werks', 'maktx', 'meins', 'matkl', 'extwg', 'mtpos_mara', 'gewei', 'magrv', 'mtvfp', 'tragr', 'ladgr', 'vhart', 'ergew', 'ergei', 'gewto', 'ervol', 'ervoe', 'volto', 'dismm', 'beskz', 'perkz', 'prmod', 'peran', 'anzpr', 'kzini', 'siggr', 'autru', 'modav', 'iprkz', 'creator_id', 'updater_id'], 'required'],
            [['mbrsh', 'ergew', 'gewto', 'ervol', 'volto', 'anzpr', 'siggr', 'creator_id', 'updater_id'], 'integer'],
            [['status'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['matnr', 'matkl', 'extwg'], 'string', 'max' => 32],
            [['mtart', 'werks', 'meins', 'mtpos_mara', 'gewei', 'magrv', 'mtvfp', 'tragr', 'ladgr', 'vhart', 'ergei', 'ervoe', 'dismm', 'beskz', 'perkz', 'prmod', 'peran', 'kzini', 'autru', 'modav', 'iprkz'], 'string', 'max' => 5],
            [['maktx'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'matnr' => 'Matnr',
            'mbrsh' => 'Mbrsh',
            'mtart' => 'Mtart',
            'werks' => 'Werks',
            'maktx' => 'Maktx',
            'meins' => 'Meins',
            'matkl' => 'Matkl',
            'extwg' => 'Extwg',
            'mtpos_mara' => 'Mtpos Mara',
            'gewei' => 'Gewei',
            'magrv' => 'Magrv',
            'mtvfp' => 'Mtvfp',
            'tragr' => 'Tragr',
            'ladgr' => 'Ladgr',
            'vhart' => 'Vhart',
            'ergew' => 'Ergew',
            'ergei' => 'Ergei',
            'gewto' => 'Gewto',
            'ervol' => 'Ervol',
            'ervoe' => 'Ervoe',
            'volto' => 'Volto',
            'dismm' => 'Dismm',
            'beskz' => 'Beskz',
            'perkz' => 'Perkz',
            'prmod' => 'Prmod',
            'peran' => 'Peran',
            'anzpr' => 'Anzpr',
            'kzini' => 'Kzini',
            'siggr' => 'Siggr',
            'autru' => 'Autru',
            'modav' => 'Modav',
            'iprkz' => 'Iprkz',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }
}

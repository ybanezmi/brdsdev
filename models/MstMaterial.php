<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_material".
 *
 * @property string $item_code
 * @property string $barcode
 * @property string $upc_1
 * @property string $upc_2
 * @property string $description
 * @property string $pallet_ind
 * @property string $sled
 * @property string $sled_unit
 * @property string $status
 * @property string $creator_id
 * @property string $created_date
 * @property string $updater_id
 * @property string $updated_date
 *
 * @property MstMaterialConversion $mstMaterialConversion
 */
class MstMaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mst_material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_code', 'barcode', 'description', 'pallet_ind', 'sled_unit', 'creator_id', 'updater_id'], 'required'],
            [['upc_1', 'upc_2', 'sled', 'creator_id', 'updater_id'], 'integer'],
            [['status'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['item_code', 'barcode'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 100],
            [['pallet_ind'], 'string', 'max' => 10],
            [['sled_unit'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_code' => 'Item Code',
            'barcode' => 'Barcode',
            'upc_1' => 'Upc 1',
            'upc_2' => 'Upc 2',
            'description' => 'Description',
            'pallet_ind' => 'Pallet Ind',
            'sled' => 'Sled',
            'sled_unit' => 'Sled Unit',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMstMaterialConversion()
    {
        return $this->hasOne(MstMaterialConversion::className(), ['material_code' => 'item_code']);
    }
}

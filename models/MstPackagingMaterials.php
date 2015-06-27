<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_packaging_materials".
 *
 * @property integer $id
 * @property string $material_code
 * @property string $plant_location
 * @property string $pallet_type
 * @property string $pallet_ind
 * @property string $description
 * @property string $material_type
 * @property integer $creator_id
 * @property string $created_date
 * @property integer $updater_id
 * @property string $updated_date
 */
class MstPackagingMaterials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mst_packaging_materials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_code', 'plant_location', 'pallet_type', 'pallet_ind', 'description', 'material_type', 'creator_id', 'created_date', 'updater_id', 'updated_date'], 'required'],
            [['creator_id', 'updater_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['material_code', 'plant_location', 'pallet_type', 'pallet_ind'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 250],
            [['material_type'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_code' => 'Material Code',
            'plant_location' => 'Plant Location',
            'pallet_type' => 'Pallet Type',
            'pallet_ind' => 'Pallet Ind',
            'description' => 'Description',
            'material_type' => 'Material Type',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_material_conversion".
 *
 * @property string $material_code
 * @property string $unit_1
 * @property string $num_1
 * @property string $den_1
 * @property string $unit_2
 * @property string $num_2
 * @property string $den_2
 * @property string $unit_3
 * @property integer $num_3
 * @property integer $den_3
 *
 * @property MstMaterial $materialCode
 */
class MstMaterialConversion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mst_material_conversion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_code', 'unit_1', 'num_1', 'den_1', 'unit_2', 'num_2', 'den_2', 'unit_3', 'num_3', 'den_3'], 'required'],
            [['num_1', 'den_1', 'num_2', 'den_2', 'num_3', 'den_3'], 'integer'],
            [['material_code'], 'string', 'max' => 32],
            [['unit_1', 'unit_2', 'unit_3'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'material_code' => 'Material Code',
            'unit_1' => 'Unit 1',
            'num_1' => 'Num 1',
            'den_1' => 'Den 1',
            'unit_2' => 'Unit 2',
            'num_2' => 'Num 2',
            'den_2' => 'Den 2',
            'unit_3' => 'Unit 3',
            'num_3' => 'Num 3',
            'den_3' => 'Den 3',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialCode()
    {
        return $this->hasOne(MstMaterial::className(), ['item_code' => 'material_code']);
    }
}

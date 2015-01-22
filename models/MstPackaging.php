<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_packaging".
 *
 * @property string $id
 * @property string $pallet_type
 * @property string $pallet_ind
 * @property string $creator_id
 * @property string $created_date
 * @property string $updater_id
 * @property string $updated_date
 */
class MstPackaging extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mst_packaging';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pallet_type', 'pallet_ind', 'creator_id', 'updater_id'], 'required'],
            [['creator_id', 'updater_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['pallet_type', 'pallet_ind'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pallet_type' => 'Pallet Type',
            'pallet_ind' => 'Pallet Ind',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }
}

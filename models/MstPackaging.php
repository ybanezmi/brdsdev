<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_packaging".
 *
 * @property string $id
 * @property string $material_group
 * @property string $status
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
            [['material_group', 'creator_id', 'updater_id'], 'required'],
            [['status'], 'string'],
            [['creator_id', 'updater_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['material_group'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_group' => 'Material Group',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }
}

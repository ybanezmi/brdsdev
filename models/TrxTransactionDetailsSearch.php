<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrxTransactionDetails;

/**
 * TrxTransactionDetailsSearch represents the model behind the search form about `app\models\TrxTransactionDetails`.
 */
class TrxTransactionDetailsSearch extends TrxTransactionDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'transaction_id', 'batch', 'net_weight', 'total_weight', 'pallet_weight', 'kitted_unit', 'creator_id', 'updater_id'], 'integer'],
            [['customer_code', 'material_code', 'pallet_no', 'manufacturing_date', 'expiry_date', 'pallet_type', 'status', 'created_date', 'updated_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $static_params)
    {
        $query = TrxTransactionDetails::find()->where($static_params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'batch' => $this->batch,
            'net_weight' => $this->net_weight,
            'total_weight' => $this->total_weight,
            'pallet_weight' => $this->pallet_weight,
            'kitted_unit' => $this->kitted_unit,
            'manufacturing_date' => $this->manufacturing_date,
            'expiry_date' => $this->expiry_date,
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'material_code', $this->material_code])
            ->andFilterWhere(['like', 'pallet_no', $this->pallet_no])
            ->andFilterWhere(['like', 'pallet_type', $this->pallet_type])
            ->andFilterWhere(['like', 'status', $this->status]);

        // created date range filter
        if (isset($this->start_date) && $this->start_date != null) {
            $startDate = explode(' - ', $this->start_date);
            $startDateFrom = Yii::$app->dateFormatter->convert($startDate[0]);
            $startDateTo = Yii::$app->dateFormatter->convert($startDate[1]);
            $query->andFilterWhere(['between', 'start_date', $startDateFrom, $startDateTo]);
        }

        return $dataProvider;
    }
}

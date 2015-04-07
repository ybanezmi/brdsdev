<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrxTransactions;

/**
 * TrxTransactionsSearch represents the model behind the search form about `app\models\TrxTransactions`.
 */
class TrxTransactionsSearch extends TrxTransactions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pallet_count', 'quantity', 'weight', 'packaging_id', 'creator_id', 'updater_id'], 'integer'],
            [['customer_code', 'inbound_no', 'sap_no', 'plant_location', 'storage_location', 'unit', 'lower_hu', 'remarks', 'truck_van', 'status', 'created_date', 'updated_date'], 'safe'],
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
    public function search($params)
    {
        $query = TrxTransactions::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pallet_count' => $this->pallet_count,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
            'packaging_id' => $this->packaging_id,
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'customer_code', $this->customer_code])
            ->andFilterWhere(['like', 'inbound_no', $this->inbound_no])
            ->andFilterWhere(['like', 'sap_no', $this->sap_no])
            ->andFilterWhere(['like', 'plant_location', $this->plant_location])
            ->andFilterWhere(['like', 'storage_location', $this->storage_location])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'lower_hu', $this->lower_hu])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'truck_van', $this->truck_van])
            ->andFilterWhere(['like', 'status', $this->status]);

        // created date range filter
        if (isset($this->created_date) && $this->created_date != null) {
            $createdDate = explode(' - ', $this->created_date);
            $createdDateFrom = Yii::$app->dateFormatter->convert($createdDate[0]);
            $createdDateTo = Yii::$app->dateFormatter->convert($createdDate[1]);
            $query->andFilterWhere(['between', 'created_date', $createdDateFrom, $createdDateTo]);
        }

        return $dataProvider;
    }
}

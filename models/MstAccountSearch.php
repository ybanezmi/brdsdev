<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MstAccount;

/**
 * MstAccountSearch represents the model behind the search form about `app\models\MstAccount`.
 */
class MstAccountSearch extends MstAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'updater_id'], 'integer'],
            [['account_type', 'username', 'password', 'auth_key', 'access_token', 'first_name', 'last_name', 'assignment', 'next_assignment', 'start_date', 'end_date', 'next_start_date', 'next_end_date', 
              'last_login_date', 'status', 'created_date', 'updated_date'], 'safe'],
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
        $query = MstAccount::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		$query->where(['status' => Yii::$app->params['STATUS_ACTIVE']]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'last_login_date' => $this->last_login_date,
            'creator_id' => $this->creator_id,
            'created_date' => $this->created_date,
            'updater_id' => $this->updater_id,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'account_type', $this->account_type])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'assignment', $this->assignment])
            ->andFilterWhere(['like', 'status', $this->status]);

        // start date range filter
        if (isset($this->start_date) && $this->start_date != null) {
            $startDate = explode(' - ', $this->start_date);
            $startDateFrom = Yii::$app->dateFormatter->convert($startDate[0]);
            $startDateTo = Yii::$app->dateFormatter->convert($startDate[1]);
            $query->andFilterWhere(['between', 'start_date', $startDateFrom, $startDateTo]);
        }

        // end date range filter
        if (isset($this->end_date) && $this->end_date != null) {
            $endDate = explode(' - ', $this->end_date);
            $endDateFrom = Yii::$app->dateFormatter->convert($endDate[0]);
            $endDateTo = Yii::$app->dateFormatter->convert($endDate[1]);
            $query->andFilterWhere(['between', 'end_date', $endDateFrom, $endDateTo]);
        }

        // next start date range filter
        if (isset($this->next_start_date) && $this->next_start_date != null) {
            $nextStartDate = explode(' - ', $this->next_start_date);
            $nextStartDateFrom = Yii::$app->dateFormatter->convert($nextStartDate[0]);
            $nextStartDateTo = Yii::$app->dateFormatter->convert($nextStartDate[1]);
            $query->andFilterWhere(['between', 'next_start_date', $nextStartDateFrom, $nextStartDateTo]);
        }

        // next end date range filter
        if (isset($this->next_end_date) && $this->next_end_date != null) {
            $nextEndDate = explode(' - ', $this->next_end_date);
            $nextEndDateFrom = Yii::$app->dateFormatter->convert($nextEndDate[0]);
            $nextEndDateTo = Yii::$app->dateFormatter->convert($nextEndDate[1]);
            $query->andFilterWhere(['between', 'next_end_date', $nextEndDateFrom, $nextEndDateTo]);
        }

        return $dataProvider;
    }
}

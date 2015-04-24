<?php

/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 24-04-2015
* Time :3:00 PM
*/

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\States;

/**
 * StatesSearch represents the model behind the search form about `common\models\States`.
 */
class StatesSearch extends States
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'country_id'], 'integer'],
            [['state_code', 'state_name_en', 'state_name_ru'], 'safe'],
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
        $query = States::find();

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
            'country_id' => $this->country_id,
        ]);

        $query->andFilterWhere(['like', 'state_code', $this->state_code])
            ->andFilterWhere(['like', 'state_name_en', $this->state_name_en])
            ->andFilterWhere(['like', 'state_name_ru', $this->state_name_ru]);

        return $dataProvider;
    }
}

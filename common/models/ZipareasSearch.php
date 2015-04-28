<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Zipareas;

/**
 * Created By Roopan v v <yiioverflow@gmail.com>
 * Date : 24-04-2015
 * Time :3:00 PM
 * ZipareasSearch represents the model behind the search form about `common\models\Zipareas`.
 */

class ZipareasSearch extends Zipareas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated'], 'integer'],
            [['zip', 'state', 'city', 'latitude', 'longitude', 'old_lng', 'old_lat'], 'safe'],
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
        $query = Zipareas::find();

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
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'zip', $this->zip])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'old_lng', $this->old_lng])
            ->andFilterWhere(['like', 'old_lat', $this->old_lat]);

        return $dataProvider;
    }
}

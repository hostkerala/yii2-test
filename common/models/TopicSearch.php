<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Topic;

/**
 * TopicSearch represents the model behind the search form about `common\models\Topic`.
 */
class TopicSearch extends Topic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'title', 'content', 'thumbnail'], 'safe'],
            [['topic_end', 'user_id', 'category_id', 'status', 'id'], 'integer'],
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
        $query = Topic::find();

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
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'id' => $this->id,
        ]);          

        $query->andFilterWhere(['like', 'created_at', $this->dbDateSearch($this->created_at)]);

        
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'thumbnail', $this->thumbnail]);        
        
        // date to search        
        $date = DateTime::createFromFormat('Y-m-d',$this->topic_end );
        $date->setTime(0,0,0);

        // set lowest date value
        $unixDateStart = $date->getTimeStamp();

        // add 1 day and subtract 1 second
        $date->add(new DateInterval('P1D'));
        $date->sub(new DateInterval('PT1S'));

        // set highest date value
        $unixDateEnd = $date->getTimeStamp();

        $query->andFilterWhere(
            ['between', 'topic_end', $unixDateStart, $unixDateEnd]); 

        return $dataProvider;
    }
}

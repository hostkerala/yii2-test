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
            [['created_at','topic_end','skills','title', 'content', 'thumbnail'], 'safe'],
            [['user_id', 'category_id', 'status', 'id'], 'integer'],
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
        
       if($params['skills'])
       {           
           $this->skills = $params['skills'];
       }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->joinWith('relTopicSkills');

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'skill_id'=>$this->skills,
        ]);       

        $query->andFilterWhere(["DATE_FORMAT( FROM_UNIXTIME(  `created_at` ) ,  '%m/%d/%Y' )"=>$this->created_at])
                ->andFilterWhere(["DATE_FORMAT( FROM_UNIXTIME(`topic_end` ) ,  '%m/%d/%Y' )"=>$this->topic_end]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'thumbnail', $this->thumbnail]);         

        return $dataProvider;
    }
}

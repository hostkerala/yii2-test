<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\db\QueryBuilder;

use Yii;

/**
 * This is the model class for table "skill".
 *
 * @property integer $id
 * @property string $name
 * @property integer $counter
 *
 * @property RelTopicSkills[] $relTopicSkills
 * @property Topic[] $topics
 */
class Skill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'counter'], 'required'],
            [['counter'], 'integer'],
            [['name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'counter' => 'Counter',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelTopicSkills()
    {
        return $this->hasMany(RelTopicSkills::className(), ['skill_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['id' => 'topic_id'])->viaTable('rel_topic_skills', ['skill_id' => 'id']);
    }
    
    public static function getAllSkill()
    {        
       $skills = (new \yii\db\Query())
                ->select(['name'])
                ->from('skill')
                ->one();
        
        if (is_array($skills))
            return $skills;
            return [];
    }
    
    public static function addTags($skills, $topic_id)
    {
            $arraySkills = explode(',', strtolower(strip_tags($skills)));
            foreach ($arraySkills as $skill) {
                    $skillModel = common\models\Skill::find(['name' => trim($skill)])->one();
                    if (!$skillModel) {
                            $skillModel = new common\models\Skill();
                            $skillModel->name = trim($skill);
                            $skillModel->save();
                    }
            }            
                        
            $sql = "DELETE FROM rel_topic_skills WHERE topic_id=$topic_id";
            Yii::$app->db->createCommand($sql)->execute();

            foreach ($arraySkills as $skill) {
                    $skillId = \common\models\Skill::find(['name' => trim($skill)])->one()->id;
                    Yii::$app()->db->createCommand()->insert('rel_topic_skills',[
                            'topic_id' => $topic_id,
                            'skill_id' => $skillId,
                    ]);
            }
            $this->countUsedSkill();    
            
            }    
    
    public static function getTopicSkill($topic_id = '')
    {
            $str = null;
            if (!empty($topic_id)) {

                    $modeltopicskills = RelTopicSkills::find(['topic_id' => $topic_id])->all();
                    if ($modeltopicskills) {
                        $arrayModels = \yii\helpers\ArrayHelper::map($modeltopicskills, 'skill_id','skill.name'); //id = your ID model, name = your caption                          
                        $str = implode(',', $arrayModels);
                    }
            }
            return $str;
    }    
    
    private function countUsedSkill()
    {
        $query = new Query;
        $query2 = new Query;
        $queryBuilder = new QueryBuilder;
        $query->select('id')
                ->from('skill');
        $arraySkill = $query->all(); 

        if ($arraySkill) {
            foreach ($arraySkill as $value) {
                foreach ($value as $id) 
                    {
                        $query2->select('COUNT(skill_id)')
                        ->from('rel_topic_skills')
                        ->where('skill_id = ' . $id)->one();
                        $sql = $queryBuilder->update('skill', ['counter' => $query2,'id'=>':id'],'age > 30',[':id' => $id]);
                        $sql->execute();
                }

            }
        }
    }    
}

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
        $arraySkills = array_filter(explode(',', strtolower(strip_tags($skills))));
        foreach ($arraySkills as $skill) {
                $query = new Query;
                $skillModel = $query->select("name")->from('skill')->where(['name'=>trim($skill)])->scalar();                  
                if (!$skillModel) {
                        $skillModel = new Skill();
                        $skillModel->name = trim($skill);
                        $skillModel->save();
                }                     
        }    
        $sql = "DELETE FROM rel_topic_skills WHERE topic_id=$topic_id";            
        Yii::$app->db->createCommand($sql)->execute();

        foreach ($arraySkills as $skill) {
                $skillId = $query->select("id")->from('skill')->where(['name'=>trim($skill)])->scalar();                  
                Yii::$app->db->createCommand()->insert('rel_topic_skills',[
                        'topic_id' => $topic_id,
                        'skill_id' => $skillId,
                ])->execute();                    
        }
        self::countUsedSkill();
    }    
    
    public static function getTopicSkill($topic_id = '')
    {
            $str = null;
            if (!empty($topic_id)) {

                    $modeltopicskills = RelTopicSkills::find()->where(['topic_id' => $topic_id])->all();
                    if ($modeltopicskills) {
                        $arrayModels = \yii\helpers\ArrayHelper::map($modeltopicskills, 'skill_id','skill.name'); //id = your ID model, name = your caption                          
                        $str = implode(',', $arrayModels);
                    }
            }
            return $str;
    }    
    
    
    public static function getUserSkill($user_id = '')
    {
            $str = null;
            if (!empty($topic_id)) {

                    $modeluserkills = RelUserSkills::find()->where(['user_id' => $user_id])->all();
                    if ($modeluserkills) {
                        $arrayModels = \yii\helpers\ArrayHelper::map($modeluserkills, 'skill_id','skill.name'); //id = your ID model, name = your caption                          
                        $str = implode(',', $arrayModels);
                    }
            }
            return $str;
    } 
    
    
    private static function countUsedSkill()
    {
            
        $query = new Query;
        $arraySkill = $query->select('id')->from('skill')->all();  
        $queryCounter = new Query;   
           
        if ($arraySkill) {
                foreach ($arraySkill as $value) {
                        foreach ($value as $id) {
                            $queryCounterData = $queryCounter->select('COUNT(skill_id)')->from('rel_topic_skills')->where('skill_id = ' . $id)->scalar();
                            Yii::$app->db->createCommand("UPDATE skill SET counter=$queryCounterData  WHERE id=:id") ->bindValue(':id', $id) ->execute();
                        }

                }
        }
    }   
}

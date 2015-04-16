<?php

namespace common\models;

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
        return (new \yii\db\Query())
        ->select(['name'])
        ->from('skill')
        ->one();
    }
    
    public static function addTags($skills, $topic_id)
    {
            $arraySkills = explode(',', strtolower(strip_tags($skills)));
            foreach ($arraySkills as $skill) {
                    $skillModel = Skill::model()->findByAttributes(array('name' => trim($skill)));
                    if (!$skillModel) {
                            $skillModel = new Skill();
                            $skillModel->name = trim($skill);
                            $skillModel->save();
                    }
            }

            Yii::app()->db->createCommand()->delete('rel_topic_skills', 'topic_id=:topic_id', $params = array(':topic_id' => $topic_id));

            foreach ($arraySkills as $skill) {
                    $skillId = Skill::model()->findByAttributes(array('name' => trim($skill)))->id;
                    Yii::app()->db->createCommand()->insert('rel_topic_skills', array(
                            'topic_id' => $topic_id,
                            'skill_id' => $skillId,
                    ));
            }
            $this->countUsedSkill();
    }    
}

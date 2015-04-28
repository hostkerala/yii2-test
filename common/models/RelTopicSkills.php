<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rel_topic_skills".
 *
 * Created By Roopan v v <yiioverflow@gmail.com>
 * Date : 24-04-2015
 * Time :3:00 PM
 * 
 * @property integer $skill_id
 * @property integer $topic_id
 *
 * @property Skill $skill
 * @property Topic $topic
 */
class RelTopicSkills extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_topic_skills';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['skill_id', 'topic_id'], 'required'],
            [['skill_id', 'topic_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'skill_id' => 'Skill ID',
            'topic_id' => 'Topic ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'skill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
}

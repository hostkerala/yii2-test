<?php

/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 24-04-2015
* Time :3:00 PM
*/

namespace common\models;

use Yii;

/**
 * This is the model class for table "rel_user_skills".
 *
 * @property integer $skill_id
 * @property integer $user_id
 */
class RelUserSkills extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_user_skills';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['skill_id', 'user_id'], 'required'],
            [['skill_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'skill_id' => 'Skill ID',
            'user_id' => 'User ID',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }    
}

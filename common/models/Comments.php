<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $content
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $userId
 * @property integer $topicId
 *
 * @property Topic $topic
 * @property User $user
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'createdAt'], 'required'],
            [['content'], 'string'],
            [['topicId','createdAt', 'updatedAt'], 'safe'],
            [['userId', 'topicId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'userId' => 'User ID',
            'topicId' => 'Topic ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topicId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
    
    public function isAbletoComment($userId, $topicId)
    {
        if(Yii::$app->user->identity->isAdmin)
        {
            return true;                
        }
        else if(\common\models\Comments::find()->where(['userId'=>$userId,'topicId'=>$topicId])->one())
        {
            return false;                
        }
        else
        {
            return true;
        }
    }
}   

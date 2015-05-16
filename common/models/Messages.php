<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property string $content
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $userId
 * @property integer $topicId
 * @property string $attach_file
 * @property integer $message_to
 *
 * @property Topic $topic
 * @property User $user
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'createdAt'], 'required'],
            [['content', 'attach_file'], 'string'],
            [['topicId','createdAt', 'updatedAt', 'attach_file','message_to','userId','message_to'], 'safe'],
            [['attach_file'], 'file', 'extensions'=>'pdf'],
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
            'attach_file' => 'Attach File',
            'message_to' => 'Message To',
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
}

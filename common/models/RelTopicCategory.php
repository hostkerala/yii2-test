<?php


/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 24-04-2015
* Time :3:00 PM
*/

namespace common\models;

use Yii;

/**
 * This is the model class for table "rel_topic_category".
 *
 * @property integer $categories_id
 * @property integer $topic_id
 *
 * @property Categories $categories
 * @property Topic $topic
 */
class RelTopicCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_topic_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categories_id', 'topic_id'], 'required'],
            [['categories_id', 'topic_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categories_id' => 'Categories ID',
            'topic_id' => 'Topic ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasOne(Categories::className(), ['id' => 'categories_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
}

<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * 
 * Created By Roopan v v <yiioverflow@gmail.com>
 * Date : 24-04-2015
 * Time :3:00 PM
 * 
 * This is the model class for table "topic".
 *
 * @property string $created_at
 * @property integer $topic_end
 * @property integer $user_id
 * @property integer $category_id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property string $thumbnail
 * @property integer $id
 *
 * @property Comments[] $comments
 * @property RelTopicCategory[] $relTopicCategories
 * @property Categories[] $categories
 * @property RelTopicSkills[] $relTopicSkills
 * @property Skill[] $skills
 */
class Topic extends \yii\db\ActiveRecord
{
    public $skills;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic';
    }

   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at','skills'], 'safe'],
            [['topic_end', 'user_id', 'category_id', 'title', 'content'], 'required'],
            [['user_id', 'category_id', 'status'], 'integer'],
            [['content'], 'string'],
            [['title', 'thumbnail'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created_at' => 'Created At',
            'topic_end' => 'Topic End',
            'user_id' => 'User',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'thumbnail' => 'Thumbnail',
            'id' => 'ID',
            'skills'=>'Skills',
            'category_id'=>'Category'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['topicId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelTopicCategories()
    {
        return $this->hasMany(RelTopicCategory::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'categories_id'])->viaTable('rel_topic_category', ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelTopicSkills()
    {
        return $this->hasMany(RelTopicSkills::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getSkills()
    {
        return $this->hasMany(Skill::className(), ['id' => 'skill_id'])
                    ->viaTable('rel_topic_skills', ['topic_id' => 'id']);
    }
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 24-04-2015
    * Time :3:00 PM
    * Changing the format of topic_end, setting the created_at if new record.
    */
    
    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {            
            $this->created_at = time();        
        }
        
        $this->topic_end = strtotime($this->topic_end);
        
        return parent::beforeSave($insert);
    }
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 24-04-2015
    * Time :3:00 PM
    * After saving the Topics saving Skills of the specific topic
    */
    
    public function afterSave($insert, $changedAttributes)
    {
    
        $skillContent = Yii::$app->request->post('Topic')['skills'];
        if ($skillContent)
        {
            Skill::addTags($skillContent, $this->id);
        }
        else
        {            
            $sql = "DELETE FROM rel_topic_skills WHERE topic_id=$this->id";
            Yii::$app->db->createCommand($sql)->execute();
        }
        parent::afterSave($insert, $changedAttributes);
    }
    
    public static function isAuthor($topicId)
    {            
       $topic = Topic::find()->where(['id'=>$topicId,'user_id'=>yii::$app->user->id])->one();
       
        if($topic->id)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 24-04-2015
    * Time :3:00 PM
    * Returns the Comments sorted order (DESC).
    */
    
    public function getSortedComments()
    {
      return $this->hasMany(Comments::className(), ['topicId' => 'id'])->orderBy(['comments.id'=>SORT_DESC]);
    }
   
}

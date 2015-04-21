<?php
namespace common\models;
use yii\db\Query;

use Yii;
use yii\helpers\Html;

class Profile extends \yii\db\ActiveRecord
{
    
    public $skills;
    public $country_id;
    public $user_id;
    public $imageDisplay;
    
    const IMAGE_PLACEHOLDER = '/frontend/web/images/default_user.jpg';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','state_id','city_id','country_id','email'], 'required'], 
            [['skills','avatar'], 'safe'], 
            [['avatar'], 'file', 'extensions'=>'jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_name' => 'Username',
            'email' => 'Email',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'skills'=>'Select Skills',
        ];
    }
    
    public function saveUserSkills($skills,$user_id)
    {
        $arraySkills = array_filter(explode(',', strtolower(strip_tags($this->skills))));
        foreach ($arraySkills as $skill) {
            $query = new Query;
            $skillModel = $query->select("name")->from('skill')->where(['name'=>trim($skill)])->scalar();                  
            if (!$skillModel) {
                    $skillModel = new Skill();
                    $skillModel->name = trim($skill);
                    $skillModel->save();
            }     
        }  
        $sql = "DELETE FROM rel_user_skills WHERE user_id=$user_id";            
        Yii::$app->db->createCommand($sql)->execute();
        foreach ($arraySkills as $skill) {
                $skillId = $query->select("id")->from('skill')->where(['name'=>trim($skill)])->scalar();                  
                Yii::$app->db->createCommand()->insert('rel_user_skills',[
                        'user_id' => $user_id,
                        'skill_id' => $skillId,
                ])->execute();                    
        }
    }
    
    /**
     * get User skills
     * @return array
     */
    
    public static function getUserSkills($user_id = '')
    {
            $str = null;
            if (!empty($user_id)) {

                    $modeluserskills = RelUserSkills::find()->where(['user_id' => $user_id])->all();
                    if ($modeluserskills) {
                        $arrayModels = \yii\helpers\ArrayHelper::map($modeluserskills, 'skill_id','skill.name'); //id = your ID model, name = your caption                          
                        $str = implode(',', $arrayModels);
                    }
            }
            return $str;
    } 

    /**
     * get User skills
     * @return string
     */
    public function getUserSkillsString()
    {
            $skills = $this->userSkills;
            $result = array();
            foreach ($skills as $skill) {
                    $result[] = $skill['name'];
            }
            return implode(',', $result);
    }   
    
    /**
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$this->isNewRecord)
            {
                $this->saveUserSkills($this->skills,yii::$app->user->id);             
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function getDisplayImage() 
    {
        $model= \common\models\Profile::find()->where(['id'=>yii::$app->user->id])->one();
        
        if (empty($model->avatar)) {
            // if you do not want a placeholder
            $image = null;
        }
        else {
            $image = Html::img(Yii::$app->urlManager->baseUrl . '/uploads/' . $model->avatar, [
                'alt'=>Yii::t('app', 'Avatar for ') . $model->username,
                'title'=>Yii::t('app', 'Click remove button below to remove this image'),
                'class'=>'img-thumbnail'
                // add a CSS class to make your image styling consistent
            ]);
        }

        // enclose in a container if you wish with appropriate styles
        return ($image == null) ? null : 
            Html::tag('div', $image, ['class' => 'file-preview-frame']); 
    }    
}

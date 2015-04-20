<?php
namespace common\models;
use dektrium\user\models\Profile as BaseProfile;
use yii\db\Query;

use Yii;

class Profile extends \yii\db\ActiveRecord
{
    
    public $skills;
    public $country_id;
    
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
            [['skills'], 'safe'], 
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
        $arraySkills = explode(',', strtolower(strip_tags($this->skills)));
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

                    $modeluserskills = RelUserSkills::find(['user_id' => $user_id])->all();
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
    
}

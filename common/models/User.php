<?php

namespace common\models;

use dektrium\user\Finder;
use dektrium\user\helpers\Password;
use dektrium\user\Mailer;
use dektrium\user\Module;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\log\Logger;
use yii\db\Query;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

use dektrium\user\models\User as BaseUser;

use Yii;


/**
 * This is the model class for table "user".
 *
 * Created By Roopan v v <yiioverflow@gmail.com>
 * Date : 24-04-2015
 * Time :3:00 PM
 * 
 * @property integer $id
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $confirmed_at
 * @property string $unconfirmed_email
 * @property integer $blocked_at
 * @property string $registration_ip
 * @property integer $flags
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $username
 * @property integer $role
 * @property string $password
 * @property integer $address
 * @property integer $city_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $phone
 * @property string $secret_key
 * @property string $avatar
 * @property integer $state_id
 *
 * @property Comments[] $comments
 * @property States $state
 * @property Zipareas $city
 */
class User extends BaseUser
{
   
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
            [['password_hash', 'auth_key', 'confirmed_at', 'unconfirmed_email', 'blocked_at', 'registration_ip', 'flags', 'email', 'username'], 'required'],
            [['confirmed_at', 'blocked_at', 'flags', 'role', 'address', 'city_id', 'created_at', 'updated_at', 'state_id'], 'integer'],
            [['password_hash'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['unconfirmed_email', 'secret_key', 'avatar'], 'string', 'max' => 255],
            [['registration_ip'], 'string', 'max' => 45],
            [['first_name', 'last_name', 'email', 'username', 'password'], 'string', 'max' => 128],
            [['phone'], 'string', 'max' => 15],
            [['email'], 'unique']
        ];
    }
    
    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'register' => ['username', 'email', 'password'],
            'connect'  => ['username', 'email'],
            'create'   => ['username', 'email', 'password','role'],
            'update'   => ['username', 'email', 'password','role'],
            'settings' => ['username', 'email', 'password']
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'confirmed_at' => 'Confirmed At',
            'unconfirmed_email' => 'Unconfirmed Email',
            'blocked_at' => 'Blocked At',
            'registration_ip' => 'Registration Ip',
            'flags' => 'Flags',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'username' => 'Username',
            'role' => 'Role',
            'password' => 'Password',
            'address' => 'Address',
            'city_id' => 'City ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'phone' => 'Phone',
            'secret_key' => 'Secret Key',
            'avatar' => 'Avatar',
            'state_id' => 'State ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['userId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::className(), ['id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Zipareas::className(), ['id' => 'city_id']);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelUserSkills()
    {
        return $this->hasMany(RelUserSkills::className(), ['user_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    public function getUserSkillsString()
    { 
            $skills = $this->userSkills;
            $result = array();
            foreach ($skills as $skill) {
                    $result[] = $skill['name'];
            }
            return implode(',', $result);
            echo $this->userSkills;exit;
    } 
    
    /**
     * get User skills
     * @return array
     */
    public function getUserSkills()
    {            
        $query = new Query;
        $query->select('*')
            ->from('skill')
            ->where('user_id = :id')
            ->join('INNER JOIN','rel_user_skills', 'rel_user_skills.skill_id = id')
            ->params([':id' => $this->id]);
        
        $tags = $query->all();
        //$command = $query->createCommand();
        // $command->sql returns the actual SQL
        //$rows = $command->queryAll();
        return $tags;
    }
    
    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->confirmed_at = time();

        if ($this->password == null) {
            $this->password = Password::generate(8);
        }
        
        if ($this->username === null) {
            $this->generateUsername();
        }
        $this->trigger(self::USER_CREATE_INIT);
        if ($this->save()) {
            $this->trigger(self::USER_CREATE_DONE);
            $this->mailer->sendWelcomeMessage($this);
            \Yii::getLogger()->log('User has been created', Logger::LEVEL_INFO);
            return true;
        }

        \Yii::getLogger()->log('An error occurred while creating user account', Logger::LEVEL_ERROR);

        return false;
    }  
    
    /**
    * @return admin users array
    */
    public function getAdmins()
    {  
        return ArrayHelper::getColumn($this->find()->select('username')->where(['role'=>1])->asArray()->all(), 'username', false);
    }
    
    /**
     * @return bool Whether the user is an admin or not.
     */
    public function getIsAdmin()
    {
         return in_array($this->username, $this->admins);
    }
    
}

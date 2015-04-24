<?php

/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 24-04-2015
* Time :3:00 PM
*/

namespace common\models;

use Yii;

/**
 * This is the model class for table "states".
 *
 * @property integer $id
 * @property string $state_code
 * @property integer $country_id
 * @property string $state_name_en
 * @property string $state_name_ru
 *
 * @property Countries $country
 * @property User[] $users
 */
class States extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'states';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state_code', 'country_id', 'state_name_en', 'state_name_ru'], 'required'],
            [['country_id'], 'integer'],
            [['state_code', 'state_name_en', 'state_name_ru'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'state_code' => 'State Code',
            'country_id' => 'Country ID',
            'state_name_en' => 'State Name En',
            'state_name_ru' => 'State Name Ru',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['state_id' => 'id']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getZipareas()
    {
        return $this->hasMany(Zipareas::className(), ['state' => 'id']);
    }
}

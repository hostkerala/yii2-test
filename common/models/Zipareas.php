<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zipareas".
 *
 * Created By Roopan v v <yiioverflow@gmail.com>
 * Date : 24-04-2015
 * Time :3:00 PM
 * 
 * @property integer $id
 * @property string $zip
 * @property string $state
 * @property string $city
 * @property string $latitude
 * @property string $longitude
 * @property string $old_lng
 * @property string $old_lat
 * @property integer $updated
 *
 * @property User[] $users
 */
class Zipareas extends \yii\db\ActiveRecord
{
    
    public $country_id;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zipareas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id','zip', 'state', 'city'], 'required'],
            [['updated'], 'integer'],
            [['zip'], 'string', 'max' => 5],
            [['state'], 'string', 'max' => 2],
            [['city', 'latitude', 'longitude', 'old_lng', 'old_lat'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zip' => 'Zip',
            'state' => 'State',
            'city' => 'City',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'old_lng' => 'Old Lng',
            'old_lat' => 'Old Lat',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['city_id' => 'id']);
    }
}

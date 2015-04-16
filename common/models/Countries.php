<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $country_iso_2
 * @property string $country_iso_3
 * @property string $country_name_en
 * @property string $country_name_ru
 *
 * @property States[] $states
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_iso_2', 'country_iso_3', 'country_name_en', 'country_name_ru'], 'required'],
            [['country_iso_2'], 'string', 'max' => 2],
            [['country_iso_3'], 'string', 'max' => 3],
            [['country_name_en', 'country_name_ru'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_iso_2' => 'Country Iso 2',
            'country_iso_3' => 'Country Iso 3',
            'country_name_en' => 'Country Name En',
            'country_name_ru' => 'Country Name Ru',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(States::className(), ['country_id' => 'id']);
    }
}

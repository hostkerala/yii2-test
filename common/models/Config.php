<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $param
 * @property string $value
 * @property string $default_value
 * @property string $label
 * @property string $type
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['param', 'value', 'default_value', 'label', 'type'], 'required'],
            [['param', 'type'], 'string', 'max' => 128],
            [['value', 'default_value', 'label'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param' => 'Param',
            'value' => 'Value',
            'default_value' => 'Default Value',
            'label' => 'Label',
            'type' => 'Type',
        ];
    }
}

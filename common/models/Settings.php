<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $option_name
 * @property string|null $option_value
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_name'], 'required'],
            [['option_value'], 'string'],
            [['option_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option_name' => 'Option Name',
            'option_value' => 'Option Value',
        ];
    }


    /**
     * @param string $option_name
     * @return mixed common\models\Settings or null
     */
    public static function findOption($option_name)
    {
        return Settings::findOne(['option_name' => $option_name]);
    }


    /**
     * @param string $option_name
     * @return mixed
     */
    public static function findOptionValue($option_name)
    {
        $option = Settings::findOption($option_name);

        if(is_object($option)) {

            return $option->option_value;
        }
        return null;
    }


    /**
     * For json stored data like social media or contact details
     * @param string $option_name
     * @return array
     */
    public static function findOptionValueAsArray($option_name)
    {
        $option_value = Settings::findOptionValue($option_name);

        if(!empty($option_value)) {

            $array_check = json_decode($option_value, true);
            
            if(is_array($array_check)) {
                return $array_check;
            }
        }
        return [];
    }


    public static function getHomepage()
    {
        $homepage_id = Settings::findOption('homepage_id');

        $page = Page::findOne(['id' => $homepage_id, 'status' => 'public']);

        return $page;
    }
}

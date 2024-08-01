<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "layout".
 *
 * @property int $id
 * @property string $title
 * @property string $data
 * @property string $render
 */
class Layout extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'layout';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'data'], 'required'],
            [['data', 'render'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'data' => 'Data',
            'render' => 'Render',
        ];
    }
}

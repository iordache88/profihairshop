<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_attribute_value".
 *
 * @property int $id
 * @property int $variation_id
 * @property int $attribute_value_id
 *
 * @property AttributeValue $attributeValue
 * @property Variation $variation
 */
class ProductAttributeValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_attribute_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['variation_id', 'attribute_value_id'], 'required'],
            [['variation_id', 'attribute_value_id'], 'integer'],
            [['variation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Variation::class, 'targetAttribute' => ['variation_id' => 'id']],
            [['attribute_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttributeValue::class, 'targetAttribute' => ['attribute_value_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'variation_id' => 'Variation ID',
            'attribute_value_id' => 'Attribute Value ID',
        ];
    }

    /**
     * Gets query for [[AttributeValue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValue()
    {
        return $this->hasOne(AttributeValue::class, ['id' => 'attribute_value_id']);
    }

    /**
     * Gets query for [[Variation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariation()
    {
        return $this->hasOne(Variation::class, ['id' => 'variation_id']);
    }
}

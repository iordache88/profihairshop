<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "variation".
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $name
 * @property string|null $featured_image
 * @property string $sku
 * @property float|null $price
 * @property float|null $sale_price
 * @property int $stock
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Product $product
 * @property ProductAttributeValue[] $productAttributeValues
 */
class Variation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'sku'], 'required'],
            [['product_id', 'stock', 'status'], 'integer'],
            [['price', 'sale_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'featured_image'], 'string', 'max' => 255],
            [['sku'], 'string', 'max' => 100],
            [['sku'], 'unique'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'featured_image' => 'Featured Image',
            'sku' => 'Sku',
            'price' => 'Price',
            'sale_price' => 'Sale Price',
            'stock' => 'Stock',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[ProductAttributeValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, ['variation_id' => 'id']);
    }
}

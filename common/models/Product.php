<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $sku
 * @property float|null $regular_price
 * @property float|null $sale_price
 * @property string|null $short_description
 * @property string|null $long_description
 * @property string|null $builder_content
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $featured_image
 * @property string|null $gallery
 * @property int $stock
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProductVariation[] $productVariations
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'sku'], 'required'],
            [['regular_price', 'sale_price'], 'number'],
            [['short_description', 'long_description', 'builder_content', 'meta_description'], 'string'],
            [['gallery', 'created_at', 'updated_at'], 'safe'],
            [['stock', 'status'], 'integer'],
            [['name', 'slug', 'meta_title', 'featured_image'], 'string', 'max' => 255],
            [['sku'], 'string', 'max' => 100],
            [['sku'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'sku' => 'Sku',
            'regular_price' => 'Regular Price',
            'sale_price' => 'Sale Price',
            'short_description' => 'Short Description',
            'long_description' => 'Long Description',
            'builder_content' => 'Builder Content',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'featured_image' => 'Featured Image',
            'gallery' => 'Gallery',
            'stock' => 'Stock',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ProductVariations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductVariations()
    {
        return $this->hasMany(ProductVariation::class, ['product_id' => 'id']);
    }
}

<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $slug
 * @property string|null $meta_title
 * @property string|null $meta_desc
 * @property string|null $target
 * @property string|null $description
 * @property int|null $media_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 *
 * @property PageCategory[] $pageCategories
 * @property Page[] $pages
 * @property ProductCategory[] $productCategories
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    public $statusList = [10 => 'Active', 9 => 'Inactive'];

    public $targets = ['product' => 'Product', 'page' => 'Page'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'media_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'meta_title'], 'string', 'max' => 255],
            [['meta_desc'], 'string', 'max' => 1000],
            [['target'], 'string', 'max' => 50],
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
            'slug' => 'Slug',
            'meta_title' => 'Meta Title',
            'meta_desc' => 'Meta Description',
            'target' => 'Target',
            'description' => 'Description',
            'media_id' => 'Media ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }



    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }





    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if(empty($this->slug)){

            $slug = Tools::encode($this->title);

            $existent_pages_same_slug = Category::findAll(['slug' => $slug, 'target' => $this->target]);

            if(!empty($existent_pages_same_slug)) {

                $slug .= '-' . (@sizeof($existent_pages_same_slug) + 1);
            }

            $this->slug = $slug;
        }
        return true;
    }



    /**
     * Gets query for [[PageCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPageCategories()
    {
        return $this->hasMany(PageCategory::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Pages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::class, ['id' => 'page_id'])->viaTable('page_category', ['category_id' => 'id']);
    }

    /**
     * Gets query for [[ProductCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('product_category', ['category_id' => 'id']);
    }


    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id'])->andWhere(['<>', 'status', 0]);
    }


    public function getChilds()
    {
        return $this->hasMany(Category::class, ['parent_id' => 'id'])->andWhere(['<>', 'status', 0]);
    }


    public function getSubcategories()
    {
        return $this->getChilds();
    }


    /**
     * Get image src from media_id
     * @return string
     */
    public function getFeaturedImage()
    {
        $src = '';
        $media_id = $this->media_id;

        if(!empty($media_id)) {

            $media_model = Media::findOne($media_id);

            if(is_object($media_model)) {
                $src = $media_model->showSrc();
            }
        }
        return $src;
    }
}

<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $meta_title
 * @property string|null $meta_desc
 * @property string|null $content
 * @property string $type
 * @property string|null $featured_image
 * @property int $sort
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Page extends Tools
{
    public $statusList = ['public' => 'Public', 'hidden' => 'Hidden', 'trash' => 'Trash'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['sort'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'meta_title', 'featured_image'], 'string', 'max' => 255],
            [['meta_desc'], 'string', 'max' => 1000],
            [['type', 'status'], 'string', 'max' => 50],
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
            'content' => 'Content',
            'type' => 'Type',
            'featured_image' => 'Featured Image',
            'sort' => 'Sort',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

            $existent_pages_same_slug = Page::findAll(['slug' => $slug]);

            if(!empty($existent_pages_same_slug)) {

                $slug .= '-' . (@sizeof($existent_pages_same_slug) + 1);
            }

            // $last_id_sql    = "SELECT * FROM page WHERE ORDER by id DESC Limit 1";
            // $last_id        = Page::findBySql($last_id_sql)->one();
            $this->slug = $slug;
        }
        return true;
    }



    public function isFrontPage()
    {
        $homepage_id = Settings::findOptionValue('homepage_id');

        if( (is_numeric($homepage_id) && !empty($homepage_id)) && !empty($this->id)) {

            return $homepage_id == $this->id;
        }
        return false;
    }



    public function getIsFrontPage()
    {
        return $this->isFrontPage();
    }





    /**
     * Get image src from featured_image id
     * @return string
     */
    public function getFeaturedImage()
    {
        $src = '';
        $featured_image_id = $this->featured_image;

        if(!empty($featured_image_id)) {

            $media_model = Media::findOne($featured_image_id);

            if(is_object($media_model)) {
                $src = $media_model->showSrc();
            }
        }
        return $src;
    }



    public function getBuilderContent()
    {
        $content = json_decode($this->content);
        if(!empty($content)) {

            return $this->renderBuilder($content);
        }
        return '';
    }


    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('page_category', ['page_id' => 'id']);
    }



    public function getPageType()
    {
        return PageType::findOne(['type' => $this->type]);
    }


    public function getNameSingular()
    {
        $page_type = $this->getPageType();

        if(is_object($page_type)) {
            return $page_type->name_singular;
        } else {
            return 'Page';
        }
    }


    public function getNamePlural()
    {
        $page_type = $this->getPageType();

        if(is_object($page_type)) {
            return $page_type->name_plural;
        } else {
            return 'Pages';
        }
    }




}

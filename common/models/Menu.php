<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string|null $second_title
 * @property string|null $description
 * @property string $type page, product, category, url
 * @property int|null $type_id page_id, product_id, category_id
 * @property string|null $url
 * @property int|null $media_id
 * @property string $target
 * @property string|null $class_attr
 * @property string|null $data_attr
 * @property int $sort
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 */
class Menu extends \yii\db\ActiveRecord
{

    public $types = ['page' => 'Page', 'product' => 'Product', 'category' => 'Category', 'url' => 'Url'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'type_id', 'media_id', 'sort', 'status'], 'integer'],
            [['title'], 'required'],
            [['description', 'target'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'second_title', 'url', 'class_attr', 'data_attr'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'second_title' => 'Second Title',
            'description' => 'Description',
            'type' => 'Type',
            'type_id' => 'Type ID',
            'url' => 'Url',
            'media_id' => 'Media ID',
            'target' => 'Target',
            'class_attr' => 'Class Attr',
            'data_attr' => 'Data Attr',
            'sort' => 'Sort',
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



    public function search($params)
    {
        $query = $this->find();
        $query->andWhere(['<>', 'parent_id', 0]);

        $this->load($params);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'second_title', $this->second_title]);
        $query->andFilterWhere(['=', 'parent_id', $this->parent_id]);
        $query->andFilterWhere(['=', 'type_id', $this->type_id]);
        $query->andFilterWhere(['=', 'type', $this->type]);
        $query->andFilterWhere(['=', 'target', $this->target]);
        $query->andFilterWhere(['=', 'status', $this->status]);

        if(empty($params['sort'])) {
            $query->orderBy('sort asc');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  [
                'pageSize' => 100,
            ],
        ]);

        return $dataProvider;
    }


    public function getParent()
    {
        return $this->hasOne(Menu::class, ['id' => 'parent_id']);
    }


    public function getChilds()
    {
        return $this->hasMany(Menu::class, ['parent_id' => 'id']);
    }


    public function getItems()
    {
        return $this->getChilds();
    }


}

<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property string $title
 * @property string $category
 * @property string $type
 * @property int $user_id
 * @property string $created_at
 * @property string|null $response
 */
class Log extends \yii\db\ActiveRecord
{
    public $categories = [
        'pages' => 'Pages',
        'products' => 'Products',
        'media' => 'Media',
        'general' => 'General',
        'settings' => 'Settings'
    ];

    public $types = [
        'create' => 'Create',
        'read'  => 'Read',
        'update' => 'Update',
        'Delete' => 'Delete',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['response'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['type', 'category'], 'string', 'max' => 50],
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
            'category' => 'Category',
            'type' => 'Type',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'response' => 'Response',
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    public function search($params)
    {
        $query = $this->find();

        $this->load($params);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['=', 'category', $this->category]);
        $query->andFilterWhere(['=', 'type', $this->type]);
        $query->andFilterWhere(['=', 'user_id', $this->user_id]);

        if(empty($params['sort'])) {
            $query->orderBy('created_at desc');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  [
                'pageSize' => 50,
            ],
        ]);

        return $dataProvider;
    }



    public static function set($title, $category = 'general', $type = null, $response = null)
    {
        $log = new Log();
        $log->title = $title;
        $log->category = $category;
        $log->type = $type;
        $log->user_id = Yii::$app->user->identity->id;
        $log->created_at = date('Y-m-d H:i:s');
        
        if($response != null) {
            
            if(is_array($response) || is_object($response)) {

                $log->response = json_encode($response);
            } else {
                $log->response = $response;
            }
        }

        if($log->save()) {

            return [
                'status' => 'success',
                'message' => 'Log saved',
            ];
        } else {
            return [
                'status' => 'success',
                'message' => 'Log not saved. ' . json_encode($log->errors),
            ];
        }
    }
}

<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * This is the model class for table "global_section".
 *
 * @property int $id
 * @property string $name
 * @property string|null $content
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 */
class GlobalSection extends Tools
{

    public $statusList = [10 => 'Active', 9 => 'Inactive'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'global_section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'content' => 'Content',
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
        $query->andWhere(['<>', 'status', 0]);

        $this->load($params);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['=', 'status', $this->status]);

        if (empty($params['sort'])) {
            $query->orderBy('id desc');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  [
                'pageSize' => 50,
            ],
        ]);

        return $dataProvider;
    }


    public static function findById($id)
    {
        return GlobalSection::find()->andWhere(['id' => $id, 'status' => 10]);
    }


    public function render()
    {
        $content = $this->content;
        return $this->renderBuilder(json_decode($content));
    }
}

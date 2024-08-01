<?php

namespace common\models;

use yii\data\ActiveDataProvider;
use Yii;

/**
 * This is the model class for table "page_type".
 *
 * @property int $id
 * @property string $name_singular
 * @property string $name_plural
 * @property string $type This is used for page "type" and category "target"
 * @property string|null $icon
 * @property int $status
 */
class PageType extends \yii\db\ActiveRecord
{
    public $statusList = [10 => 'Active', 9 => 'Inactive'];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_singular', 'name_plural', 'type'], 'required'],
            [['status'], 'integer'],
            [['name_singular', 'name_plural', 'icon'], 'string', 'max' => 255],
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
            'name_singular' => 'Name Singular',
            'name_plural' => 'Name Plural',
            'type' => 'Type',
            'icon' => 'Icon',
            'status' => 'Status',
        ];
    }



    public function search($params)
    {
        $query = $this->find();
        $query->andWhere(['<>', 'status', 0]);

        $this->load($params);

        $query->andFilterWhere(['like', 'name_singular', $this->name_singular]);
        $query->andFilterWhere(['like', 'name_plural', $this->name_plural]);
        $query->andFilterWhere(['=', 'type', $this->type]);

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



    public function saveAndCreateFiles()
    {
        if($this->type === 'page' || $this->type === 'pages') {
            $response = [
                'status' => 'error',
                'message' => 'You would never create a page type named "page" or "pages"...',
            ];
            return $response;
        }

        $page_type_check = PageType::findOne(['type' => $this->type]);

        if(is_object($page_type_check)) {

            $response = [
                'status' => 'error',
                'message' => 'A page type "' . $this->type . '" already exists. Please check.',
            ];
            return $response;
        }


        if(!$this->validate()) {

            $response = [
                'status' => 'error',
                'message' => 'Can\'t validate page type. ' . json_encode($this->errors),
            ];
            return $response;
        }

        if($this->save()) {

            return $this->createFiles();

        } else {
            $response = [
                'status' => 'error',
                'message' => 'Can\'t save page type. ' . json_encode($this->errors),
            ];
            return $response;
        }
    }


    private function createFiles()
    {
        $type = $this->type;

        if($type === 'page' || $type === 'pages') {
            $response = [
                'status' => 'error',
                'message' => 'Failed.',
            ];
            return $response;
        }

        // Let's copy controller
        $controller_path = Yii::getAlias('@backend/controllers');

        $source_controller_name = 'Page';
        $target_controller_name = trim(ucfirst($type));

        $source_controller_path = $controller_path . '/' . $source_controller_name . 'Controller.php';
        $target_controller_path = $controller_path . '/' . $target_controller_name . 'Controller.php';

        if (!copy($source_controller_path, $target_controller_path)) {

            $response = [
                'status' => 'error',
                'message' => 'Failed to copy controller.',
            ];
            return $response;
        }

        // Replace class name inside the copied controller
        $controller_content = file_get_contents($target_controller_path);
        $controller_content = str_replace($source_controller_name . 'Controller' , $target_controller_name . 'Controller', $controller_content);

        file_put_contents($target_controller_path, $controller_content);
        //


        // Now let's copy the views..
        $views_path = Yii::getAlias('@backend/views');

        $source_views_path = $views_path . '/' . 'page';
        $target_views_path = $views_path . '/' . trim($type);

        if (!mkdir($target_views_path, 0755, true) && !is_dir($target_views_path)) {
            $response = [
                'status' => 'error',
                'message' => 'Failed to create target views directory.',
            ];
            return $response;
        }

        $files_to_copy = ['_form.php', '_subcategories-part.php', 'add.php', 'edit.php', 'index.php'];

        foreach ($files_to_copy as $file) {

            if (!copy("{$source_views_path}/{$file}", "{$target_views_path}/{$file}")) {
                $response = [
                    'status' => 'error',
                    'message' => "Failed to copy view {$file}.",
                ];
                return $response;
            }
        }

        $response = [
            'status' => 'success',
            'message' => 'Controller and views copied successfully.',
        ];
        return $response;
    }
}

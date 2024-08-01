<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $url
 * @property int|null $title
 * @property int|null $alt_title
 * @property int|null $description
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'user_id', 'status'], 'integer'],
            [['url'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['url', 'title', 'alt_title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
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
            'url' => 'Url',
            'title' => 'Title',
            'alt_title' => 'Alt Title',
            'description' => 'Description',
            'user_id' => 'User ID',
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



    public function getFolder()
    {
        return $this->hasOne(Media::class, ['id' => 'parent_id']);
    }


    public function getMedia()
    {
        return $this->hasMany(Media::class, ['parent_id' => 'id'])->orderBy('id desc');
    }


    public function getItems()
    {
        return $this->getMedia();
    }


    public function showSrc()
    {
        if(isset($this->folder->url)) {

            return '/uploads' . '/' . $this->folder->url . '/' . $this->url;
        }
        return '';
    }


    public static function findById($id)
    {
        return self::findOne($id);
    }


    public static function showImg($id)
    {
        $media_model = self::findById($id);
        if (is_object($media_model)) {

            return $media_model->showSrc();
        } else {

            return '';
        }
    }


    public static function showInfo($id, $attribute)
    {
        $media_model = self::findById($id);
        if (is_object($media_model) && $media_model->hasAttribute($attribute)) {

            return $media_model->$attribute;
        } else {

            return '';
        }
    }



    public function getFolderName()
    {
        $folder = $this->folder;
        return $folder ? $folder->url : '';
    }


    public function getFile($filePath, $attr)
    {

        if ($attr == 'icon') {

            

            if (is_object($filePath)) {
                $fileUrl = $filePath->url;
                $folderName = $filePath->getFolderName();
            } else {
                $fileUrl = $filePath;
                $folderName = '';
            }

            if (!is_string($fileUrl)) {
                return '';
            }

            $extension = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));


            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
            $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'];


            $fileIcons = [
                'pdf' => $this->getSvgIcon('pdf-icon'),
                'doc' => $this->getSvgIcon('doc-icon'),
                'docx' => $this->getSvgIcon('doc-icon'),
                'xls' => $this->getSvgIcon('xls-icon'),
            ];

            if (in_array($extension, $imageExtensions)) {
                
                return '<img width="90" height="90" src="/uploads/' . $folderName . '/' . $fileUrl . '" alt="' . $fileUrl . '" class="img-fluid img-responsive" data-toggle="modal" data-target=".modal-profile-sm">';
            }

            if (in_array($extension, $videoExtensions)) {
                return '<video width="100%" height="auto" controls><source src="/uploads/' . $folderName . '/' . $fileUrl . '" type="video/' . $extension . '"></video>';
            }


            return $fileIcons[$extension] ?? '<svg ...default icon...></svg>';
        }

        if ($attr == 'title') {

            $extension = strtolower(pathinfo($filePath->url, PATHINFO_EXTENSION));
            $fileNameFirst = str_replace(['+', '-', '_', '.', $extension], ' ', $filePath->url);
            $fileName = trim($fileNameFirst);

            return $filePath->title ?? $fileName;
        }

        if ($attr == 'url') {
            $folderName = $filePath->getFolderName();
            $fileName = $filePath->url;

            return '/uploads/' . $folderName . '/' . $fileName;
        }
    }

    public function getSvgIcon($filename) {

        $filepath = Yii::getAlias("@frontend/web/uploads/icons/{$filename}.svg");

        if(is_readable($filepath)) {
            return file_get_contents($filepath);
        }
        return '';
    }
}

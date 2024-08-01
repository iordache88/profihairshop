<?php

namespace backend\controllers;

use Yii;
use common\models\Page;
use common\models\Media;
use common\models\Tools;
use common\models\Log;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\helpers\FileHelper;
/**
 * MediaController
 */
class MediaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['login', 'error'],
                            'allow' => true,
                        ],
                        [
                            'actions' => [
                                'index',
                                 'search', 
                                 'item-more-info', 
                                 'update-item-attribute', 
                                 'delete-media-item', 
                                 'change-folder-id', 
                                 'add-folder', 
                                 'add-folder-ajax', 
                                 'add',
                                 'remove-folder',
                                 'remove-all-files-from-folder',
                                 ],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {

                                if (Yii::$app->user->identity->is_admin !== 1) {
                                    return $this->redirect('/');
                                }
                                return true;
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete'                => ['POST'],
                        'update-item-attribute' => ['POST'],
                        'delete-media-item'     => ['POST'],
                        'change-folder-id'      => ['POST'],
                        'add'                   => ['POST'],
                        'change-folder-id'      => ['POST'],
                    ],
                ],
            ]
        );
    }



    public function actionIndex()
    {
        $folders = Media::find()->andWhere(['parent_id' => 0, 'status' => 10])->all();

        return $this->render('index', ['folders' => $folders]);
    }



    public function actionAddFolder()
    {
        $folder_name = (Yii::$app->request->post('folder_name'));

        if(empty($folder_name)) {

            Yii::$app->session->setFlash('error', 'Folder name must not be empty.');
            return $this->redirect(['media/index']);
        }

        $folder            = new Media();
        $folder->parent_id = 0;
        $folder->title     = $folder_name;
        $folder->alt_title = $folder_name;
        $folder->user_id   = Yii::$app->user->identity->id;
        $folder->url       = Tools::encode($folder_name);

        $folder_existent_check = Media::findOne(['parent_id' => 0, 'url' => $folder->url, 'status' => 10]);

        if(is_object($folder_existent_check)) {

            Yii::$app->session->setFlash('error', 'Looks like there is a folder with the same name... Please choose another name.');
            return $this->redirect(['media/index']);
            
        }


        if(!$folder->save()) {

            Yii::$app->session->setFlash('error', 'Folder not saved.' . json_encode($folder->errors));
        } else {

            $folder_path = Yii::getAlias('@frontend/web/uploads/' . $folder->url);

            FileHelper::createDirectory($folder_path, $mode = 0775, $recursive = true);

            Log::set('Add media folder "' . $folder->title . '"', 'media', 'create');
        }


        return $this->redirect(['media/index']);

    }


    public function actionAddFolderAjax()
    {

        $folder_name = (Yii::$app->request->post('folder_name'));

        if(empty($folder_name)) {

            $response = [
                'status' => 'error',
                'message' =>'Folder name must not be empty.',
            ];
            return $this->asJson($response);
        }

        
        $folder            = new Media();
        $folder->parent_id = 0;
        $folder->title     = $folder_name;
        $folder->alt_title = $folder_name;
        $folder->user_id   = Yii::$app->user->identity->id;
        $folder->url       = Tools::encode($folder_name);

        $folder_existent_check = Media::findOne(['parent_id' => 0, 'url' => $folder->url, 'status' => 10]);

        if(is_object($folder_existent_check)) {

            $response = [
                'status' => 'error',
                'message' =>'Looks like there is a folder with the same name... Please choose another name.',
            ];
            return $this->asJson($response);
        }

        if(!$folder->save()) {


            $response = [
                'status' => 'error',
                'message' =>'Folder not saved. ' . json_encode($folder->errors),
            ];
            return $this->asJson($response);

        } else {

            $folder_path = Yii::getAlias('@frontend/web/uploads/' . $folder->url);

            FileHelper::createDirectory($folder_path, $mode = 0775, $recursive = true);

            $response = [
                'status' => 'success',
                'html' => $this->renderPartial('//layouts/_media-modal'),
            ];

            Log::set('Add media folder "' . $folder->title . '"', 'media', 'create', $response);
            return $this->asJson($response);
        }

    }


    public function actionAdd($folder)
    {
        $folder     = Media::findOne($folder);

        if(is_object($folder)) {

            $folderPath = $folder->url;

            $tempFile   = $_FILES['file']['tmp_name'];
            $target_dir = Yii::getAlias('@frontend/web/uploads/' . $folderPath);
            $nameFile   = $_FILES['file']['name'];

            $pathInfo = pathinfo($nameFile);

            $filenameWithoutExtension = $pathInfo['filename'];
            $fileExtension            = isset($pathInfo['extension']) ? $pathInfo['extension'] : '';

            $nameFileUrlWithoutExtension = Tools::encode($filenameWithoutExtension);

            if(!empty($fileExtension)) {

                $nameFileUrl = $nameFileUrlWithoutExtension . '.' . $fileExtension;
            }


            $sameUrlCheck = Media::find()->where(['url' => $nameFileUrl])->all();

            if(!empty($sameUrlCheck)) {

                $suff = count($sameUrlCheck) + 1;
                $nameFileUrl = $nameFileUrlWithoutExtension . '-' . $suff . '.' . $fileExtension;
            }


            $targetFile = $target_dir . '/' . $nameFileUrl;

            if(move_uploaded_file($tempFile, $targetFile)) {

                $media             = new Media();
                $media->alt_title  = $nameFile;
                $media->url        = $nameFileUrl;
                $media->user_id    = Yii::$app->user->identity->id;
                $media->parent_id  = $folder->id;

                if($media->save()) {

                    // $this->Setlog('Add media <b>'.$media->url.'</b> to folder '.$media->folder->alt_title, 'create', 'media');
                    Log::set('Add media file "' .$media->alt_title . '"', 'media', 'create');
                    return $this->asJson(['status' => 'succes', 'message' => 'Media added!']);
                }
            }

            return $this->asJson(['status' => 'error', 'message' => 'Media not added.']);

        } else {
            return $this->asJson(['status' => 'error', 'message' => 'Folder not found.']);
        }

    } 




    public function actionSearch()
    {
        $pageSize = 20;

        $post_data = Yii::$app->request->post();

        $query = Media::find();
        
        $search_keyword = $post_data['search_keyword'] ?? null;
        $folder_id      = $post_data['folder_id'] ?? null;

        if(isset($search_keyword) && strlen($search_keyword) > 0) {

            $query->andFilterWhere(['like', 'alt_title', $search_keyword]);
            $query->orFilterWhere(['like', 'url', $search_keyword]);
            $query->orFilterWhere(['like', 'title', $search_keyword]);
            $query->orFilterWhere(['like', 'description', $search_keyword]);

            $folder_check = Media::find()->andWhere(['like', 'alt_title', $search_keyword])->one();

            if(is_object($folder_check)) {
                $query->orWhere(['parent_id' => $folder_check->id]);
            }

            $query->andWhere(['>', 'parent_id', 0]);
            $query->andWhere(['status' => 10]);

            $folder = null;

            if(!empty($folder_id)){
                $query->andWhere(['parent_id' => $folder_id]);
                $folder = Media::findOne($folder_id);
            }

            $items_count = $query->count();

            $pagination = new Pagination(['totalCount' => $items_count, 'pageSize' => $pageSize]);
            $query->offset($pagination->offset);
            $query->limit($pagination->limit);
            $query->orderBy(['url' => SORT_ASC, 'alt_title' => SORT_ASC, 'title' => SORT_ASC, 'description' => SORT_ASC, 'id' => SORT_ASC]);

        } else {

            $query->andWhere(['>', 'parent_id', 0]);
            $query->andWhere(['status' => 10]);

            $folder = null;

            if(!empty($folder_id)){

                $query->andWhere(['parent_id' => $folder_id]);
                $folder = Media::findOne($folder_id);
            }

            $items_count = $query->count();
            $pagination = new Pagination(['totalCount' => $items_count, 'pageSize' => $pageSize]);

            $query->offset($pagination->offset);
            $query->limit($pagination->limit);
            $query->orderBy('created_at desc');

        }

        $items = $query->all();

        return $this->renderPartial('_items-ajax', ['items' => $items, 'search_keyword' => $search_keyword, 'items_count' => $items_count, 'folder' => $folder, 'pagination' => $pagination]);
    }


    public function actionUpdateItemAttribute()
    {
        $post_data = Yii::$app->request->post();
        $id        = $post_data['id'];
        $attribute = $post_data['attribute'];
        $value     = $post_data['value'];

        $model = Media::findOne($id);

        if(!is_object($model)) {
            return $this->asJson([
                'status' => 'error',
                'message' => 'Item not found',
            ]);
        }

        if($model->updateAttributes([$attribute => $value])) {
            
            Log::set('Change media file "' . $attribute . '" to "' . $value . '"' , 'media', 'create');

            return $this->asJson([
                'status' => 'success',
                'html' => $this->renderPartial('_item-ajax-part', ['item' => $model]),
            ]);

        } else {
            return $this->asJson([
                'status' => 'error',
                'message' => 'The media item couldn\'t be saved',
            ]);
        }
    }



    public function actionItemMoreInfo(){

        $media_item = Media::findOne(Yii::$app->request->post('id'));

        $usage_data = [

        ];

        $maybe_in_content = false;
        
        $pages = Page::find()->andWhere(['status' => 'public'])->all();

        foreach ($pages as $page) {
            
            if($page->featured_image == $media_item->id) {
                $usage_data[] = [
                    'as' => 'Featured image',
                    'on' => $page->title,
                    'url' => "/{$page->slug}",
                    'page_id' => $page->id,
                ];
            }

            $in_gallery = false;

            if(!empty($page->gallery)) {
                $page_gallery = json_decode($page->gallery, true);
                    
                if(!empty($page_gallery)) {

                    foreach($page_gallery as $gallery_item_id) {

                        if($gallery_item_id == $media_item->id) {
                            $in_gallery = true;
                        }

                    }

                }
            }

            if($in_gallery){

                $usage_data[] = [
                    'as' => 'Gallery image',
                    'on' => $page->title,
                    'url' => "/{$page->slug}",
                    'page_id' => $page->id,
                ];
            }


            if(is_object($page->content)) {

                foreach ((array)$page->content as $idRow => $row) {

                    foreach ($row as $idCol => $col) {
                        if ($idCol != 'opt') {
                        
                            foreach($col->content as $key=>$data)
                            {
                                if( (strpos(Yii::$app->tools->renderShortcode($data, $idRow, $idCol, $key), $media_item->url) !== false ) ) {

                                    $maybe_in_content = true;
                                }
                            }
                        }
                    }
                }

            } else {

                // if( (strpos(json_decode($page->content), $media_item->url) !== false ) ) {

                //     $maybe_in_content = true;
                // }
            }


            if($maybe_in_content){
                $usage_data[] = [
                    'as' => 'It may be in content',
                    'on' => $page->title,
                    'url' => "/{$page->slug}",
                    'page_id' => $page->id,
                ];
            }


            // if(Settings::findOne(['option_name' => 'logo'])->option_value == "{$media_item->folder->url}/$media_item->url") {
            //     $usage_data[] = [
            //         'as' => 'Logo',
            //         'on' => 'Site',
            //         'url' => "/",
            //     ];
            // }

            // if(Settings::findOne(['option_name' => 'favicon'])->option_value == "{$media_item->folder->url}/$media_item->url") {
            //     $usage_data[] = [
            //         'as' => 'Favicon',
            //         'on' => 'Site',
            //         'url' => "/",
            //     ];
            // }

            
        }

        return $this->renderPartial('_item_more_info', ['media_item' => $media_item, 'usage_data' => $usage_data]);
    }





    public function actionDeleteMediaItem(){

        $media = Media::find()->where(['id'=>Yii::$app->request->post('id')])->one();
        if($media->delete())
        {
            $path = $_SERVER['DOCUMENT_ROOT'].'/frontend/web/uploads/'.$media->folder->url.'/'.$media->url;
            if(file_exists($path))
            {
                unlink('../../frontend/web/uploads/'.$media->folder->url.'/'.$media->url);
            }

            Log::set('Delete media item "' . $media->url . '"', 'media', 'delete');

            return $this->asJson([
                'status' => 'success',
                'message' => 'Item deleted.'
            ]);
        }

        return $this->asJson([
            'status' => 'error',
            'message' => 'This media item could\'t be deleted.',
        ]);
    }




    public function actionChangeFolderId(){

        $id = Yii::$app->request->post('id');
        $folder_id = Yii::$app->request->post('folder_id');

        $media_item = Media::findOne($id);

        $old_folder = $media_item->folder;
        $new_folder = Media::findOne($folder_id);

        $file_old_path = Yii::getAlias("@frontend/web/uploads/{$old_folder->url}/{$media_item->url}");
        $file_new_path = Yii::getAlias("@frontend/web/uploads/{$new_folder->url}/{$media_item->url}");


        if($media_item->updateAttributes(['parent_id' => $folder_id])) {

            if(is_readable($file_old_path)) {
                
                rename($file_old_path, $file_new_path);
            }

            Log::set('Move media item from "' . $old_folder->url . '" to "' . $new_folder->url . '"' , 'media', 'update');

            return $this->asJson([
                'status' => 'success',
                'message' => 'Item folder updated.'
            ]);
        } else {

            return $this->asJson([
                'status' => 'error',
                'message' => 'The item folder can\'t be changed.'
            ]);
        }
    }


    public function actionRemoveFolder()
    {
        $folder_id = Yii::$app->request->post('folder_id');

        $folder = Media::findOne($folder_id);

        if(is_object($folder)) {

            if(empty($folder->media)) {

                if($folder->delete()) {

                    if(rmdir(Yii::getAlias('@frontend/web/uploads/'.$folder->url))) {

                        Log::set('Remove media folder "' . $folder->url . '"', 'media', 'delete');

                        $response = [
                            'status' => 'success',
                            'message' => 'Folder deleted!', 
                        ];
                        return $this->asJson($response);

                    } else {

                        $response = [
                            'status' => 'success',
                            'message' => 'Folder deleted from the database. It may still be available on the server.', 
                        ];
                        return $this->asJson($response);
                    }

                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Folder not deleted', 
                    ];
                    return $this->asJson($response);
                }

            } else {

                $response = [
                    'status' => 'error',
                    'message' => 'Folder not empty', 
                ];
                return $this->asJson($response);
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Folder not found', 
            ];
            return $this->asJson($response);
        }
    }



    public function actionRemoveAllFilesFromFolder()
    {
        $folder_id = Yii::$app->request->post('folder_id');

        $folder = Media::findOne($folder_id);

        if(is_object($folder)) {

            if(empty($folder->media)) {

                $response = [
                    'status' => 'error',
                    'message' => 'No files found.', 
                ];
                return $this->asJson($response);
                
            } else {

                foreach($folder->media as $media_item) {

                    if($media_item->delete()) {

                        if(file_exists(Yii::getAlias('@frontend/web/uploads/'. $folder->url .'/' .$media_item->url))) {

                            unlink(Yii::getAlias('@frontend/web/uploads/'. $folder->url .'/' .$media_item->url));
                        }

                    } else {

                        $response = [
                            'status' => 'error',
                            'message' => 'Media item not deleted', 
                        ];
                        return $this->asJson($response);
                    }
                }

                $response = [
                    'status' => 'success',
                    'message' => 'Media items deleted!', 
                ];
                Log::set('Remove all files from folder "' . $folder->url . '"', 'media', 'delete', $response);
                return $this->asJson($response);
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Folder not found', 
            ];
            return $this->asJson($response);
        }
    }

}
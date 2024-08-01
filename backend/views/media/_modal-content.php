<?php

use common\models\Media;
use yii\widgets\ActiveForm;

$folders = Media::find()->andWhere(['parent_id' => 0, 'status' => 10])->all();

?>



<div class="modal-header">
    <h5 class="modal-title">Media </h5>
    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="row mb-4">


                    <div class="col-lg-12 text-lg-right align-self-center">
                        <div class="upload-media-box-wrp prevented">
                            <form action="/backend/web/media/add?folder=4" class="dropzone dropzone-upload-media" id="dropzoneFrom" method="POST" data-folder="4" enctype="multipart/form-data"></form>
                            <div class="prevent-upload-mask">Choose folder to upload...</div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-3">

                        <div class="media-folders-box">



                            <?php
                            foreach ($folders as $folder) {

                                $data_type_attr = 'altele';

                                $countItems = count($folder->media);
                                echo '<div class="folder-list-item" data-id="' . $folder->id . '" data-type="' . $data_type_attr . '">';
                                echo '<a href="#" class="folder-list-item-link">';
                                echo  '<div class="folder-item-icon">';
                                echo '<i class="fas fa-folder fa-9x"></i>';
                                echo '</div>';
                                echo '<p class="folder-title">' . $folder->alt_title . ' - <span class="count_folder_files">' . $countItems . '</span> files</p>';
                                echo '</a>';
                                echo '</div>';
                            }
                            ?>


                            <?php
                            echo '<div class="folder-list-item">';
                            echo '<a href="#" class="folder-list-item-link" data-bs-toggle="modal" data-bs-target="#addFolder">';
                            echo  '<div class="folder-item-icon">';
                            echo '<i class="fas fa-folder-plus"></i>';
                            echo '</div>';
                            echo '<p class="folder-title">Add</p>';
                            echo '</a>';
                            echo '</div>';
                            ?>

                        </div>

                    </div>

                    <div class="col-md-9">

                        <div class="media-items-box">
                            <div class="col-lg-12 align-self-center">
                                <div class="search-media-box mb-4">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">Search...</label>
                                        <input type="text" class="input-search-media form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="media-items-receiver">

                            </div>
                            <div class="media-items-loading" style="display: none;">
                                <div class="spinner-border" role="status"><span class="sr-only"></span></div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
<?php

use yii\widgets\ActiveForm;

$this->title = 'Media | ' . Yii::$app->name;
?>

<div class="media-library">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">

                            <div class="col-md-10">
                                <h3 class="m-0">Media library</h3>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">

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

        <!-- Modal Add media -->
        <div id="addFolder" tabindex="-1" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <?php
                    ActiveForm::begin([
                        'id' => 'form-add-media',
                        'action' => ['media/add-folder'],
                    ])
                    ?>

                    <div class="modal-body">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <h5 class="modal-title font-weight-normal">Add folder</h5>
                            </div>
                            <div class="card-body pb-3">
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="folder_name" class="form-control" value="" placeholder="Write the folder name..." />
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-100">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php ActiveForm::end(); ?>
                </div>

            </div>

        </div>
    </div>
</div>

<?php 

    $header_image_src = Yii::$app->fields->show('projects', $project->ID, 'header-image-src', 0);

?>

<div class="container-fluid">
    <div class="row main-categ-row single-prod space-bottom">

        <div class="col-12 left-navbar-container px-0 project-sidebar">
            <div class="module module-widget">
                <?= json_decode(Yii::$app->tools->showWidget(4)->content) ?>
            </div>
        </div>

        <div class="col-12 categ-view justify-content-start px-0">
            <div class="categories-header-wrapper">
                <div class="categories-header">
                <span class="arrow-down"></span>

                    <img src="<?= Yii::$app->media->showImg($project->featured_image) ?>" />

                    <h1 class="title">
                        <?= $project->title ?>
                    </h1>
                </div>
            </div>

            <div class="single-product-header-image-wrapper">
                <div class="single-product-header-image" style="background-image: url(<?= $header_image_src ?>)"></div>
                <div class="floating-image">
                </div>
            </div>

            <div class="row single-project-desc">
                <?= json_decode($project->content) ?>
            </div>
            
        
            <?php if(!empty(Yii::$app->media->showGallery($project->ID, 'project-lightbox-slider'))){
                echo '<div class="single-project-gallery">'.Yii::$app->media->showGallery($project->ID, 'project-lightbox-slider').'</div>';
            }
            ?>     

            <div class="text-center mt-5">    
                <p><a href="/contact" class="btn main-btn">Contactează-ne</a></p>
            </div>
        </div>

    </div>
</div>



    
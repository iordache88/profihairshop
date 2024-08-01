<?php 

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $_id string */
/* @var $_class string */
/* @var $type string */
/* @var $colsize string */
/* @var $limit int */
/* @var $direction string */
/* @var $pages array */
/* @var $paginate mixed */

?>


<div <?= empty($_id) ? '' : "id='$_id'" ?> class="module module-field <?= $_class ?>">

    <?php if(!empty($pages)) { ?>

    <div class="row">

        <?php 
        foreach($pages as $page) {

            $img_src = Yii::$app->media->showImg($page->featured_image);

            $img_alt = Yii::$app->media->showInfo($page->featured_image, 'alt_title');

            $url     = Url::to("/{$page->slug}");

            ?>


            <div class="col-md-<?= $colsize; ?>">

                <div class="grid-item">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title"><a href="<?= $url; ?>"><?= $page->title; ?></a></h3>
                        </div>

                        <a href="<?= $url; ?>"><img class="card-img-top img-fluid" src="<?= $img_src; ?>" alt="<?= $img_alt; ?>"></a>

                    </div>
                </div>

            </div>

            <?php

        }
        ?>

    </div>
    <?php } ?>

    <p class="module-field-empty"></p>

</div>
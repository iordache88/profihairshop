<?php

    $id = null;
    if(!empty($_id))
    {
        $id = 'id="'.$_id.'"';
    }
    echo '<div ' . $id . ' class="row categories-grid ' . $_class . '">';

    foreach($subcategories as $subcategory)
    {
        $imageUrl = Yii::$app->media->showImg($subcategory->ID_media);
        
        echo 
        '<div class="col-12 col-xl-4 col-lg-4 col-md-6 col-sm-6 categories-item-wrapper">
            <div class="category-item">
                <a href="/category/'.$subcategory->slug.'">
                    <div class="category-item-inner">
                        <div class="categ-image-wrapper">
                            <img class="categ-image" src="'. $imageUrl .'" >
                        </div>
                        <div class="categ-title">
                            <h2>' . $subcategory->title . '</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>';
    }

    echo '</div>';

?>
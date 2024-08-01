<?php

    $id = null;
    if(!empty($_id))
    {
        $id = 'id="'.$_id.'"';
    }
    echo '<div ' . $id . ' class="row categories-grid ' . $_class . '">';

    foreach($pages as $page)
    {
        $imageUrl = Yii::$app->media->showImg($page->featured_image);

        $langs = unserialize(Yii::$app->tools->settings('lang'));
        $langUrl = null;

        $i=0;
        foreach($langs as $key=>$lng)
        {
            if($i!=0 && $key == Yii::$app->language)
            {
                $langUrl = '/'.$lng[0]; 
            }
            $i++;
        }
        
        echo 
        '<div class="col-12 col-xl-'.$colsize.' col-lg-'.$colsize.' col-md-6 col-sm-6 categories-item-wrapper">
            <div class="category-item">
                    <div class="category-item-inner">
                        <div class="categ-image-wrapper">
                            <a href="'.$langUrl.'/'.$page->slug.'"><img class="categ-image" src="'. $imageUrl .'" ></a>
                        </div>
                        <div class="categ-title">
                            <h2><a href="'.$langUrl.'/'.$page->slug.'">' . $page->title . '</a></h2>
                            
                        </div>
                    </div>
            </div>
        </div>';
    }

    echo '</div>';

?>
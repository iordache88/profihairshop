<?php
    include('_filters.php');

    /* @var $pages array */

    echo '<div class="row categories-grid">';

    foreach($pages as $page)
    {
        $imageUrl = Yii::$app->media->showImg($page->featured_image);
        $price = Yii::$app->fields->show('products', $page->ID, 'pret', 0);
        $price = number_format($price, 2);

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
        
        // NU STERGE
        // <a href="'.$langUrl.'/'.$page->slug.'"><img class="categ-image" src="'. $imageUrl .'" ></a>
        
        
        echo 
        '<div class="col-12 col-xl-'.$colsize.' col-lg-'.$colsize.' col-md-6 col-sm-6 categories-item-wrapper">
            <div class="category-item">'; 
    
                $stare = Yii::$app->fields->show('products', $page->ID, 'stare-produs', 0);
                if ($stare == 'Nou') {
                    echo '<div class="product-state">'.Yii::$app->fields->show('products', $page->ID, 'stare-produs', 0).'</div>';
                } else {
                    
                }
                echo '<div class="category-item-inner">
                        <div class="categ-image-wrapper">
                            <figure>
                                
                                <a href="'.$langUrl.'/'.$page->slug.'">
                                <img src="'.$imageUrl.'" class="img-fluid">
                            </a>
                        </figure>
                        <span class="quickview">'.Yii::$app->tools->quickView($page->ID, 'icon').'</span>
                        </div>
                        <div class="categ-title">
                            <h2><a href="'.$langUrl.'/'.$page->slug.'">' . $page->title . '</a></h2>
                            <div class="short-desc">'.$page->meta_desc.'</div>';
                			if(!empty(Yii::$app->fields->show('products', $page->ID, 'pret-redus', 0))) {
                			    $stare_pret = Yii::$app->fields->show('products', $page->ID, 'stare-pret', 0);
                                if ($stare_pret == 'Reducere') {
                                    echo '<div class="price-state">'.Yii::$app->fields->show('products', $page->ID, 'stare-pret', 0).'</div>';
                                } else {
                                    
                                }
                				echo '<div class="price" style="text-decoration: line-through; font-size:14px!important;margin:auto!important;line-height:1;height:auto;">'.Yii::$app->fields->show('products', $page->ID, 'pret', 0).' lei <span>(TVA inclus)</span></div>';
                				echo '<div class="price-online">'.Yii::$app->fields->show('products', $page->ID, 'pret-redus', 0).' lei <span>(TVA inclus)</span><div class="info-price">Exclusiv online</div></div>';
                			}
                			else 
                			{ 
                				echo '<div style="height:80px;display:flex;flex-direction:column;justify-content:center;" class="price">'.Yii::$app->fields->show('products', $page->ID, 'pret', 0).' lei <span>(TVA inclus)</span></div>';
                			}

                            
                            echo '<div class="product-stock"';
    						$color ="#000000";
    						if(!empty(Yii::$app->fields->show('products', $page->ID, 'disponibilitate', 0))) {
    						    $disp = Yii::$app->fields->show('products', $page->ID, 'disponibilitate', 0);
        						if ($disp == 'In stoc') {
                                   $color = "#00d600";
        						} else if ($disp == 'Stoc limitat') {
        						    $color ="#fe9600";
        						} else if ($disp =='Stoc epuizat') {
        						    $color= "#ff5500";
        						} else {
        						    
        						}
                                echo '<p style="color:'.$color.'"><span>●</span>'.Yii::$app->fields->show('products', $page->ID, 'disponibilitate', 0).'</p>';
    						} else {
    						    echo '<p><a style="color:var(--orange); text-decoration:none;" href="/contact">Afla stocul produsului</a></p>';
    						}
                            echo '</div>
                            <div class="button-wrapper">'.Yii::$app->tools->addToCart($page->ID).'</div>
                        </div>
                    </div>
            </div>
        </div>';
    }

    echo '</div>';

?>
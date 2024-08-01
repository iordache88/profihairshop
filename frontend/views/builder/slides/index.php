<!------------------------------->
<!------- CAROUSER SLIDER ------->
<!------------------------------->

<?php

$interval = $slide->content;
// $interval  = 112345678989;
?>

<div class="e-slider-wrapper">
  <div id="e-slider" class="e-slider" data-pause="hover" data-interval="<?php echo $interval; ?>">

    <!-- SLIDER CONTROLER -->
    <div class="slider-indicators-wrapper">
      <ol class="slider-indicators">

        <?php
          $i = 1;
          foreach ($slide->child as $item) {
            $active = '';
            if ($i == 1) {
              $active = 'active';
            }
            echo '<li data-target="#e-slide" data-item="' . $i . '" class="' . $active . '"></li>';
            $i++;
          }
        ?>

      </ol>
    </div>
    <!-- SLIDER CONTROLER -->


    <!-- SLIDER CONTENT -->
    <div class="slider-inner">

      <?php
      $i = 1;
      foreach ($slide->child as $item) {
        $active = '';
        if ($i == 1) {
          $active = 'active';
        }
        $setup = unserialize($item->setup);

        $textIndent = '';
        if($setup['textIndent'] == 1)
        {
          $textIndent = 'style="text-indent: 25px;"';
        }

        echo '<div class="slide-item ' . $active . '" data-item="'. $i .'">';
        echo '<div class="slide-image" data-image="'.Yii::$app->media->showImg($item->ID_media) . '" alt="' . $i . ' slide"></div>';
        echo '<div class="slide-content text-'.$setup['positionContent'].'">
              <h3>
                ' . $item->title . '
              </h3>
              <p '.$textIndent.'>
                ' . $item->content . '
              </p>';
          
        if($setup['btnText'] != '') {
         echo '<div class="btn-wrapper"><a href="' . $item->btn_url . '" class="btn-slider" style="color: '.$setup['btnTextColor'].'; background: '.$setup['btnBackgroundColor'].'" target="'.$setup['btnTarget'].'">'.$setup['btnText'].'</a></div>';
        }
        echo '</div>';

        if(!empty($item->ID_image))
        {
          echo '<img class="slide-sm-image image'.$i.'" src="'.Yii::$app->media->showImg($item->ID_image).'" alt="'.Yii::$app->media->showInfo($item->ID_image, 'alt_title').'" title="'.Yii::$app->media->showInfo($item->ID_image, 'title').'">';
        }

        echo '</div>';
        $i++;
      }
      ?>

    </div>
    <!-- SLIDER CONTENT -->



  </div>

</div>